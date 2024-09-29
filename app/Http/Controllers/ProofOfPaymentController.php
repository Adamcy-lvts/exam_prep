<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProofOfPaymentController extends Controller
{
    public function downloadProof(Payment $payment)
    {
        dd('downloadable');
        if (!$payment->proof_of_payment) {
            abort(404, 'Proof of payment not found.');
        }

        $path = Storage::disk('public')->path($payment->proof_of_payment);

        if (!Storage::disk('public')->exists($payment->proof_of_payment)) {
            abort(404, 'File not found.');
        }

        $fileName = basename($path);

        return response()->download($path, $fileName);
    }
}
