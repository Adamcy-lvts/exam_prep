<?php

namespace App\Http\Controllers;

use App\Models\JambAttempt;
use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public $user;
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        // Verify payment status
        if ($paymentDetails['status'] === true && $paymentDetails['data']['status'] === 'success') {
            DB::beginTransaction();
            try {
                $userEmail = $paymentDetails['data']['customer']['email'];
                $this->user = User::where('email', $userEmail)->firstOrFail();
                $planId = $paymentDetails['data']['metadata']['planId'] ?? null;

                // Check if planId is provided and valid
                if (!$planId || !$plan = Plan::find($planId)) {
                    throw new Exception('Invalid plan ID or plan not found.');
                }

                // Record the payment
                $payment = new Payment([
                    'user_id' => $this->user->id,
                    'amount' => $paymentDetails['data']['amount'] / 100, // Paystack amount is in kobo
                    'method' => $paymentDetails['data']['channel'],
                    'plan_id' =>  $planId, // This should be dynamic based on your logic
                    'attempts_purchased' => $plan->number_of_attempts,
                    'card_type' => $paymentDetails['data']['authorization']['card_type'],
                    'bank' => $paymentDetails['data']['authorization']['bank'],
                    'last_4_digits' => $paymentDetails['data']['authorization']['last4'],
                    'status' => 'completed',
                    'authorization_code' => $paymentDetails['data']['authorization']['authorization_code'],
                    'transaction_id' => $paymentDetails['data']['reference'],
                ]);
                $payment->save();

                $this->manageSubscription($this->user, $plan);

                DB::commit();

                // Depending on the type of plan, redirect to the appropriate page
                switch ($plan->type) {
                    case 'subject':
                        $redirectTo = route('filament.user.resources.subjects.jamb-instrcution'); // or wherever you wish to send the user
                        break;
                    case 'course':
                        $redirectTo = route('filament.user.resources.courses.index'); // Adjust the route as needed
                        break;
                    
                }

                // Send confirmation to the user
                // $user->notify(new PaymentConfirmedNotification($payment));

                // Redirect the user to the determined route
                return redirect($redirectTo);
            } catch (\Throwable $e) {
                DB::rollback();
                Log::error('Error confirming payment: ' . $e->getMessage());
                return response()->json(['message' => 'Internal Server Error'], 500);
            }
        } else {
            // Handle failed payment
            Log::error('Payment failed', $paymentDetails);
            return response()->json(['message' => 'Payment failed.'], 500);
        }
    }

    private function manageSubscription(User $user, Plan $newPlan)
    {
        // Retrieve any active subscription, regardless of the plan.
        $currentSubscription = $user->subscriptions()
            ->where('ends_at', '>', now())
            ->orderBy('ends_at', 'desc') // In case there are multiple, get the latest.
            ->first();

        $expiresAt = now()->addDays($newPlan->validity_days ?? 0);

        if ($currentSubscription) {
            // If switching between different plans...
            if ($currentSubscription->plan_id != $newPlan->id) {
                // Optional: Determine if any proration or adjustments are needed.
                // This might involve calculating the unused portion of the current subscription
                // and applying its value towards the new subscription, adjusting the `expiresAt` accordingly.

                // End the current subscription early.
                $currentSubscription->update(['status' => 'cancelled', 'ends_at' => now(), 'cancelled_at' => now()]);

                // Create a new subscription for the new plan.
                $this->createNewSubscription($user, $newPlan, $expiresAt);
            } else {
                // If re-purchasing the same plan, extend the existing subscription.
                $currentSubscription->update(['ends_at' => $expiresAt]);
            }
        } else {
            // If no active subscription exists, create a new subscription.
            $this->createNewSubscription($user, $newPlan, $expiresAt);
        }

        // Reset attempts or apply other plan-specific logic.
        $this->resetAttempts($user, $newPlan);
    }

    private function createNewSubscription(User $user, Plan $plan, $expiresAt)
    {
        $user->subscriptions()->create([
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => $expiresAt,
            'status' => 'active', // Consider your logic for setting status
            'features' => $plan->features // Copying features from plan to subscription
        ]);
    }

    private function resetAttempts(User $user, Plan $plan)
    {
        // Update the attempts based on the purchased plan
        switch ($plan->type) {
            case 'subject':
                // Check if the plan offers unlimited attempts
                $this->resetSubjectAttempts($user, $plan);
                break;
            case 'course':
                $this->resetCourseAttempts($user, $plan);
                break;
            default:
                // Handle other plan types or throw an exception if unknown
                throw new Exception('Unknown plan type.');
        }
    }

    public function resetSubjectAttempts(User $user, Plan $plan)
    {
        // Retrieve all subjects for the user
        $subjects = $user->subjects;

        // Iterate over each subject to reset attempts
        foreach ($subjects as $subject) {
            $subjectAttempt = $user->subjectAttempts()->where('subject_id', $subject->id)->first();

            // If there is an existing subject attempt record, reset attempts to 0
            if ($subjectAttempt) {
                $subjectAttempt->update(['attempts_left' => 0]);
            }
        }

        // Retrieve the user's JAMB attempt record
        $jambAttempt = $user->jambAttempts()->first();

        // If there is an existing JAMB attempt record, reset attempts to 0
        if ($jambAttempt) {
            $jambAttempt->update(['attempts_left' => 0]);
        }
        // Check if the plan offers unlimited attempts
        if (is_null($plan->number_of_attempts)) {
            // Set attempts_left to null for unlimited attempts
            $subjects = $user->subjects;
            foreach ($subjects as $subject) {
                $user->subjectAttempts()->updateOrCreate(
                    ['subject_id' => $subject->id],
                    ['attempts_left' => null] // Indicate unlimited attempts
                );
            }
            $jambAttempt = $this->user->jambAttempts()->first();
            $jambAttempt->attempts_left = null; // Indicate unlimited attempts
            $jambAttempt->save();
        } else {
            // For plans with a limited number of attempts
            $subjects = $user->subjects;
            foreach ($subjects as $subject) {
                $user->subjectAttempts()->updateOrCreate(
                    ['subject_id' => $subject->id],
                    ['attempts_left' => $plan->number_of_attempts]
                );
            }

            $jambAttempt = $this->user->jambAttempts()->first();
            if ($jambAttempt) {
                $jambAttempt->increment('attempts_left', $plan->number_of_attempts);
            } else {
                $this->user->jambAttempts()->create([
                    'attempts_left' => $plan->number_of_attempts // Set specific number of attempts
                ]);
            }
        }
    }

    // public function resetCompositeAttempts(User $user, Plan $plan)
    // {
    //     if (is_null($plan->number_of_attempts)) {
    //         // If the plan is unlimited, set attempts_left to null
    //         $jambAttempt = $this->user->jambAttempts();
    //         $jambAttempt->attempts_left = null; // Indicate unlimited attempts
    //         $jambAttempt->save();

    //         // Set attempts_left to null for unlimited attempts
    //         $subjects = $user->subjects;
    //         foreach ($subjects as $subject) {
    //             $user->subjectAttempts()->updateOrCreate(
    //                 ['subject_id' => $subject->id],
    //                 ['attempts_left' => null] // Indicate unlimited attempts
    //             );
    //         }
    //     } else {
    //         // For a specific number of attempts
    //         $jambAttempt = $this->user->jambAttempts()->first();
    //         if ($jambAttempt) {
    //             $jambAttempt->increment('attempts_left', $plan->number_of_attempts);
    //         } else {
    //             $this->user->jambAttempts()->create([
    //                 'attempts_left' => $plan->number_of_attempts // Set specific number of attempts
    //             ]);
    //         }

    //         // For plans with a limited number of attempts
    //         $subjects = $user->subjects;
    //         foreach ($subjects as $subject) {
    //             $user->subjectAttempts()->updateOrCreate(
    //                 ['subject_id' => $subject->id],
    //                 ['attempts_left' => $plan->number_of_attempts]
    //             );
    //         }
    //     }

    // }

    public function resetCourseAttempts(User $user, Plan $plan)
    {
        if ($this->user->courses->count() > 0) {
            if (is_null($plan->number_of_attempts)) {
                // Set attempts_left to null for unlimited attempts
                $courses = $user->courses;
                foreach ($courses as $course) {
                    $user->subjectAttempts()->updateOrCreate(
                        ['subject_id' => $course->id],
                        ['attempts_left' => null] // Indicate unlimited attempts
                    );
                }
            } else {
                // For plans with a limited number of attempts
                $courses = $user->courses;
                foreach ($courses as $course) {
                    $user->subjectAttempts()->updateOrCreate(
                        ['subject_id' => $course->id],
                        ['attempts_left' => $plan->number_of_attempts]
                    );
                }
            }
        }
    }
}
