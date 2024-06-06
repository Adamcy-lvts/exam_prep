<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Models\Agent;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\JambAttempt;
use App\Mail\PaymentReceipt;
use Illuminate\Http\Request;
use App\Models\ReferralPayment;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public $user;
    public $payment;
    public $receipt;

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
                $agentId = $paymentDetails['data']['metadata']['agent_id'] ?? null;

                // Check if planId is provided and valid
                if (!$planId || !$plan = Plan::find($planId)) {
                    throw new Exception('Invalid plan ID or plan not found.');
                }

                $user = auth()->user();
                $referral = $user->referringAgents()->first();

                // Default to an empty collection if 'split' or 'shares' or 'subaccounts' keys are not present
                $subaccounts = collect($paymentDetails['data']['split']['shares']['subaccounts'] ?? []);

                // Attempt to find the subaccount details using the subaccount code from the referral
                $subaccountDetails = null;
                if ($referral && $subaccounts->isNotEmpty()
                ) {
                    $subaccountDetails = $subaccounts->firstWhere('subaccount_code', $referral->subaccount_code);
                }

                // Total payment amount converted from kobo to Naira
                $totalAmount = ($paymentDetails['data']['amount'] ?? 0) / 100;
                $transactionFee = $totalAmount * 0.015; // 1.5% transaction fee
                $netAmount = $totalAmount - $transactionFee;

                $agentAmount = 0;
                $splitCode = null;

                // Check for split payment details
                if (isset($paymentDetails['data']['split'])) {
                    $agentAmount = $subaccountDetails ? ($subaccountDetails['amount'] ?? 0) / 100 : 0;
                    $splitCode = $paymentDetails['data']['split']['split_code'] ?? null;
                    $netAmount -= $agentAmount; // Deduct agent's share from net amount
                }

                // Record the payment
                $this->payment = new Payment([
                    'user_id' => $this->user->id,
                    'amount' => $totalAmount, // Paystack amount is in kobo
                    'net_amount' => $netAmount,
                    'split_amount_agent' => $agentAmount,
                    'split_code' => $splitCode,
                    'method' => $paymentDetails['data']['channel'],
                    'plan_id' =>  $planId, // This should be dynamic based on your logic
                    'attempts_purchased' => $plan->number_of_attempts,
                    'card_type' => $paymentDetails['data']['authorization']['card_type'],
                    'bank' => $paymentDetails['data']['authorization']['bank'],
                    'last_4_digits' => $paymentDetails['data']['authorization']['last4'],
                    'status' => 'completed',
                    'payment_for' => 'subscription plan',
                    'authorization_code' => $paymentDetails['data']['authorization']['authorization_code'],
                    'transaction_ref' => $paymentDetails['data']['reference'],
                ]);
                $this->payment->save();

                // Generate and save receipt after payment is successful
                $this->receipt = $this->payment->receipt()->create([
                    'payment_id' => $this->payment->id,
                    'user_id' => $this->user->id,
                    'payment_date' => now(),
                    'receipt_for' => $this->payment->payment_for, // Assuming 'Subscription' is the type for subscription payments
                    'amount' => $paymentDetails['data']['amount'] / 100,
                    'receipt_number' => Receipt::generateReceiptNumber(now()),
                    // 'remarks' and 'qr_code' can be set here if needed
                ]);

              
                
                $this->manageSubscription($this->user, $plan);

                $this->sendReceiptByEmail();

                // Record referral payment
                // Record referral payment if applicable
                if ($agentId) {
                    $this->recordReferralPayment($this->user, $agentId, $paymentDetails);
                }

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

    private function sendReceiptByEmail(): void
    {
        try {
            $payment = $this->payment;
            $receipt = $this->receipt;

            $pdf = $payment->user->first_name . '_' . $payment->user->last_name . '-' . '_receipt.pdf';
            $receiptPath = storage_path("app/{$pdf}");

            // Generate the PDF receipt
            Pdf::view('pdf-receipt-view.payment-receipt', [
                'payment' => $payment,
                'receipt' => $receipt
            ])->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->setChromePath(config('app.chrome_path'));
            })->save($receiptPath);

            // Check if the user has an email address
            if (!empty($payment->user->email)) {
                // Send the generated receipt to the customer's email
                Mail::to($payment->user->email)->queue(new PaymentReceipt($payment, $receipt, $receiptPath, $pdf));

                // Notify the user that the receipt has been sent successfully
                Notification::make()
                    ->title('Receipt sent to the customer\'s email.')
                    ->success()
                    ->send();
            } else {
                // Notify the user that the customer doesn't have a valid email
                Notification::make()
                    ->title('Failed to send deposit receipt! Customer does not have an email address.')
                    ->warning()
                    ->send();
            }
        } catch (\Exception $e) {
            // Log any exceptions that may arise during this process
            Log::error("Error sending receipt: {$e->getMessage()}");

            // Notify the user about the error
            Notification::make()
                ->title('Failed to send deposit receipt! Please try again later or send manually.')
                ->danger()
                ->send();
        }
    }

    // private function recordReferralPayment(User $user, $paymentDetails)
    // {
    //     // Assuming each user has one referring agent and there's a referral record already.
    //     $referral = $user->referringAgents()->first();

    //     if ($referral) {
    //         ReferralPayment::create([
    //             'referral_id' => $referral->id, // Assuming 'referral_id' links to a record in the agent_user table
    //             'amount' => $paymentDetails['data']['amount'] / 100, // Convert from kobo to naira
    //             'status' => 'completed', // Assuming the payment is completed at this point
    //             'payment_date' => now(), // The current date and time of the payment
    //         ]);
    //     }
    // }

    private function recordReferralPayment(User $user, $agentId, $paymentDetails)
    {
        $agent = Agent::find($agentId);
        // Assuming each user has one referring agent and there's a referral record already.
        $referral = $user->referringAgents()->first();

        if ($referral) {
            // Navigate through the nested arrays to the specific subaccount details
            $subaccounts = collect($paymentDetails['data']['split']['shares']['subaccounts']);
            $subaccountDetails = $subaccounts->firstWhere('subaccount_code', $referral->subaccount_code);

            if ($subaccountDetails) {
                ReferralPayment::create([
                    'agent_id' => $agent->id,  // Directly use agent_id
                    'user_id' => $user->id,   // Directly use user_id
                    'amount' => $subaccountDetails['amount'] / 100, // Convert from kobo to naira
                    'split_code' => $paymentDetails['data']['split']['split_code'], // Saving the split code
                    'status' => 'completed', // Assume payment is completed at this point
                    'payment_date' => now(), // Use the current date and time
                ]);
            }
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

        // // Iterate over each subject to reset attempts
        foreach ($subjects as $subject) {
            $subjectAttempt = $user->subjectAttempts()->where('subject_id', $subject->id)->first();

            // If there is an existing subject attempt record, reset attempts to 0
            if ($subjectAttempt) {
                $subjectAttempt->update(['attempts_left' => 0]);
            }
        }

        // Retrieve the user's JAMB attempt record
        $jambAttempt = $user->jambAttempts()->first();

        // // If there is an existing JAMB attempt record, reset attempts to 0
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
            if ($jambAttempt) {
                $jambAttempt->attempts_left = null; // Indicate unlimited attempts
                $jambAttempt->save();
            } else {
                $this->user->jambAttempts()->create([
                    'attempts_left' => null // Set specific number of attempts
                ]);
            }
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

    public function resetCourseAttempts(User $user, Plan $plan)
    {
        if ($this->user->courses->count() > 0) {
            if (is_null($plan->number_of_attempts)) {
                // Set attempts_left to null for unlimited attempts
                $courses = $user->courses;
                foreach ($courses as $course) {
                    $user->courseAttempts()->updateOrCreate(
                        ['course_id' => $course->id],
                        ['attempts_left' => null] // Indicate unlimited attempts
                    );
                }
            } else {
                // For plans with a limited number of attempts
                $courses = $user->courses;
                foreach ($courses as $course) {
                    $user->courseAttempts()->updateOrCreate(
                        ['course_id' => $course->id],
                        ['attempts_left' => $plan->number_of_attempts]
                    );
                }
            }
        }
    }
}
