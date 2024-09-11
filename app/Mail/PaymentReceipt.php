<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentReceipt extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $receipt;
    public $payment;
    public $pdf;
    public $receiptPath;
    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment, Receipt $receipt, $receiptPath, $pdf)
    {
        $this->payment = $payment;
        $this->receipt = $receipt;
        $this->pdf = $pdf;
        $this->receiptPath = $receiptPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('lv4mj1@gmail.com', 'Exam Pro'),
            subject: 'Payment Receipt',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $subsPlan = $this->payment->plan->title ?? 'Subscription Plan';
        return new Content(
            markdown: 'emails.payment-receipt',
            with: [
                'urlToReceipt' => route('filament.user.resources.courses.view-receipt', ['record' => $this->payment->id]),
                'subsPlan' => $subsPlan,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->receiptPath)
                ->as($this->pdf)
                ->withMime('application/pdf'),
        ];
    }
}
