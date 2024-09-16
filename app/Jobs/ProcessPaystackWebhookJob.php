<?php

namespace App\Jobs;

use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Models\Agent;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\ReferralPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use App\Mail\PaymentReceipt;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class ProcessPaystackWebhookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    public function handle()
    {
        $payload = $this->webhookCall->payload;
        $eventType = $payload['event'] ?? null;

        if ($eventType === 'charge.success') {
            $this->handlePaymentSuccess($payload['data']);
        } else {
            Log::info("Received unhandled Paystack event: {$eventType}");
        }
    }

    protected function handlePaymentSuccess($data)
    {
        try {
            $userEmail = $data['customer']['email'];
            $user = User::where('email', $userEmail)->firstOrFail();
            $planId = $data['metadata']['planId'] ?? null;
            $agentId = $data['metadata']['agentId'] ?? null;

            if (!$planId || !$plan = Plan::find($planId)) {
                throw new Exception('Invalid plan ID or plan not found.');
            }

            $payment = $this->createPayment($user, $data, $plan);
            $receipt = $this->createReceipt($payment, $data);

            $this->manageSubscription($user, $plan);
            $this->sendReceiptByEmail($payment, $receipt);

            if ($agentId) {
                $this->recordReferralPayment($user, $agentId, $data);
            }

            Log::info('Payment processed successfully', ['payment_id' => $payment->id]);
        } catch (\Throwable $e) {
            Log::error('Error processing payment webhook: ' . $e->getMessage());
        }
    }


    private function createPayment($user, $data, $plan)
    {
        $totalAmount = $data['amount'] / 100; // Convert from kobo to Naira
        $agentAmount = 0;
        $splitCode = null;
        $netAmount = $totalAmount; // Initialize with total amount, we'll adjust it later

        if (isset($data['split'])) {
            Log::info('Split data found:', ['split' => $data['split']]);
            $splitData = $data['split'];
            $shares = $splitData['shares'] ?? [];

            // Extract platform's share (our net amount)
            $netAmount = ($shares['integration'] ?? 0) / 100; // Convert from kobo to Naira

            // Extract agent's share
            $subaccounts = $shares['subaccounts'] ?? [];
            if (!empty($subaccounts)) {
                $agentAmount = $subaccounts[0]['amount'] / 100; // Convert from kobo to Naira
                $splitCode = $splitData['split_code'] ?? null;
            }

            // Calculate Paystack fee
            $paystackFee = ($shares['paystack'] ?? 0) / 100; // Convert from kobo to Naira
        }

        $paymentData = [
            'user_id' => $user->id,
            'amount' => $totalAmount,
            'net_amount' => $netAmount,
            'split_amount_agent' => $agentAmount,
            'split_code' => $splitCode,
            'paystack_fee' => $paystackFee ?? null,
            'method' => $data['channel'],
            'plan_id' => $plan->id,
            'attempts_purchased' => $plan->number_of_attempts,
            'card_type' => $data['authorization']['card_type'],
            'bank' => $data['authorization']['bank'],
            'last_4_digits' => $data['authorization']['last4'],
            'status' => 'completed',
            'payment_for' => 'subscription plan',
            'authorization_code' => $data['authorization']['authorization_code'],
            'transaction_ref' => $data['reference'],
        ];

        Log::info('Creating payment with data:', $paymentData);

        return Payment::create($paymentData);
    }

    private function createReceipt($payment, $data)
    {
        return Receipt::create([
            'payment_id' => $payment->id,
            'user_id' => $payment->user_id,
            'payment_date' => now(),
            'receipt_for' => $payment->payment_for,
            'amount' => $data['amount'] / 100,
            'receipt_number' => Receipt::generateReceiptNumber(now()),
        ]);
    }

    private function manageSubscription($user, $plan)
    {
        $currentSubscription = $user->subscriptions()
            ->where('ends_at', '>', now())
            ->orderBy('ends_at', 'desc')
            ->first();

        $expiresAt = now()->addDays($plan->validity_days ?? 0);

        if ($currentSubscription) {
            if ($currentSubscription->plan_id != $plan->id) {
                $currentSubscription->update(['status' => 'cancelled', 'ends_at' => now(), 'cancelled_at' => now()]);
                $this->createNewSubscription($user, $plan, $expiresAt);
            } else {
                $currentSubscription->update(['ends_at' => $expiresAt]);
            }
        } else {
            $this->createNewSubscription($user, $plan, $expiresAt);
        }

        $this->resetAttempts($user, $plan);
    }

    private function createNewSubscription($user, $plan, $expiresAt)
    {
        $user->subscriptions()->create([
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => $expiresAt,
            'status' => 'active',
            'features' => $plan->features
        ]);
    }

    private function resetAttempts($user, $plan)
    {
        switch ($plan->type) {
            case 'subject':
                $this->resetSubjectAttempts($user, $plan);
                break;
            case 'course':
                $this->resetCourseAttempts($user, $plan);
                break;
            default:
                throw new Exception('Unknown plan type.');
        }
    }

    private function resetSubjectAttempts($user, $plan)
    {
        $attemptsValue = is_null($plan->number_of_attempts) ? null : $plan->number_of_attempts;

        foreach ($user->subjects as $subject) {
            $user->subjectAttempts()->updateOrCreate(
                ['subject_id' => $subject->id],
                ['attempts_left' => $attemptsValue]
            );
        }

        $user->jambAttempts()->updateOrCreate(
            [],
            ['attempts_left' => $attemptsValue]
        );
    }

    private function resetCourseAttempts($user, $plan)
    {
        if ($user->courses->count() > 0) {
            $attemptsValue = is_null($plan->number_of_attempts) ? null : $plan->number_of_attempts;

            foreach ($user->courses as $course) {
                $user->courseAttempts()->updateOrCreate(
                    ['course_id' => $course->id],
                    ['attempts_left' => $attemptsValue]
                );
            }
        }
    }

    private function sendReceiptByEmail($payment, $receipt)
    {
        try {
            $pdf = $payment->user->first_name . '_' . $payment->user->last_name . '-' . '_receipt.pdf';
            $receiptPath = storage_path("app/{$pdf}");

            Pdf::view('pdf-receipt-view.payment-receipt', [
                'payment' => $payment,
                'receipt' => $receipt
            ])->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->setChromePath(config('app.chrome_path'));
            })->save($receiptPath);

            if (!empty($payment->user->email)) {
                Mail::to($payment->user->email)->queue(new PaymentReceipt($payment, $receipt, $receiptPath, $pdf));
            }
        } catch (\Exception $e) {
            Log::error("Error sending receipt: {$e->getMessage()}");
        }
    }

    private function recordReferralPayment($user, $agentId, $data)
    {
        $agent = Agent::find($agentId);
        if (!$agent) {
            Log::error('Agent not found', ['agent_id' => $agentId]);
            return;
        }

        $splitDetails = $data['split'] ?? [];
        if (empty($splitDetails)) {
            Log::error('Split details not found in payload');
            return;
        }

        $subaccounts = $splitDetails['shares']['subaccounts'] ?? [];
        if (empty($subaccounts)) {
            Log::error('No subaccounts found in split details');
            return;
        }

        $subaccountDetails = $subaccounts[0];

        ReferralPayment::create([
            'agent_id' => $agent->id,
            'user_id' => $user->id,
            'amount' => $subaccountDetails['amount'] / 100,
            'split_code' => $splitDetails['split_code'] ?? null,
            'status' => 'completed',
            'payment_date' => now(),
        ]);
    }
}
