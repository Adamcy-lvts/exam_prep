<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        // dd($paymentDetails);
        if ($paymentDetails['status'] === true && $paymentDetails['data']['status'] === 'success') {
            $planType = $paymentDetails['data']['metadata']['plan_type'] ?? 'subject';
            
            switch ($planType) {
                case 'subject':
                    $redirectTo = route('filament.user.resources.subjects.jamb-instrcution');
                    break;
                case 'course':
                    $redirectTo = route('filament.user.resources.courses.index');
                    break;
                default:
                    $redirectTo = route('dashboard');
            }

            return redirect($redirectTo)->with('success', 'Payment successful!');
        } else {
            return redirect()->route('payment.failed')->with('error', 'Payment failed.');
        }
    }
}