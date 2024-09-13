<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Receipt;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'method',
        'plan_id',
        'payment_for',
        'split_amount_agent',
        'net_amount',
        'split_code',
        'attempts_purchased',
        'card_type',
        'bank',
        'last_4_digits',
        'status',
        'authorization_code',
        'transaction_id'
    ];

    function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }

    // Payment model

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    protected static function booted()
    {
        static::created(function ($payment) {
            // Generate a receipt for every payment regardless of type.
            $payment->generateReceipt();
        });
    }

    public function generateReceipt()
    {
        // Check for an existing receipt to prevent duplicates.
        if (!$this->receipt()->exists()) {
            // Create the receipt related to the payment.
            $receipt = $this->receipt()->create([
                'user_id' => $this->user_id,
                'payment_date' => now(), // The date when the payment was made
                'receipt_for' => $this->payment_for, // The purpose of the payment, could be subscription or any other type
                'amount' => $this->amount,
                'receipt_number' => Receipt::generateReceiptNumber(now()),
                // Add any additional fields like 'remarks' or 'qr_code' if necessary.
            ]);

            if (!$receipt) {
                Log::error('Failed to create receipt for payment ID: ' . $this->id);
            }
        }
    }
}
