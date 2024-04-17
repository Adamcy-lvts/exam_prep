<x-mail::message>
# Payment Receipt

Thank you for your recent payment to {{ config('app.name') }}. Below are the details of your transaction:

@component('mail::panel')
**Plan:** {{ $subsPlan }}  
**Amount Paid:** ${{ formatNaira($payment->amount) }}  
**Date:** {{ formatDate($receipt->payment_date) }}  
**Payment Method:** {{ ucfirst($payment->method) }}
@endcomponent

A PDF copy of your receipt has been attached to this email for your records.

@if(isset($urlToOnlineReceipt))
    <x-mail::button :url="$urlToOnlineReceipt">
        View Receipt
    </x-mail::button>
@endif

If you have any questions or concerns regarding your payment, please contact our support team.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
