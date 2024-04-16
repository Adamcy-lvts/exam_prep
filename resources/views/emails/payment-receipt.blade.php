<x-mail::message>
# Payment Receipt

Thank you for your payment.

Here are the details of your subscription plan:

- **Plan:** {{ $subsPlan }}
- **Amount:** {{ formatNaira($payment->amount) }}
- **Date:** {{ formatDate($receipt->payment_date)}}

<x-mail::button :url="$urlToReceipt">
Download Receipt
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
