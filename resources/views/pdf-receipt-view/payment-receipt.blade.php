<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-3xl p-8 m-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-bold text-3xl text-gray-800 mb-4">Receipt</h1>
                <p class="text-gray-600 text-sm mb-2">Receipt number: <span
                        class="font-semibold">{{ $receipt->receipt_number }}</span></p>
                <p class="text-gray-600 text-sm mb-2">Date paid: <span
                        class="font-semibold">{{ formatDate($receipt->payment_date) }}</span></p>
                <p class="text-gray-600 text-sm mb-2">Payment method: <span
                        class="font-semibold">{{ $payment->method }}</span></p>
            </div>
            <div>
                <img src="/api/placeholder/150/50" alt="Company Logo" class="h-12 w-auto">
            </div>
        </div>

        <div class="mt-8 text-sm">
            <div class="flex justify-between mb-6">
                <div class="text-gray-700">
                    <h1 class="text-2xl font-bold">E-ExamPro</h1>
                </div>
                <div class="text-gray-700">
                    <p class="font-semibold">Bill to</p>
                    <p>{{ $receipt->user->first_name . ' ' . $receipt->user->last_name }}</p>
                    <p>{{ $receipt->user->email }}</p>
                    <p>{{ $receipt->user->phone }}</p>
                </div>
            </div>

            <div class="text-lg font-bold text-gray-800 mb-4">
                {{ formatNaira($payment->amount) }} paid on
                <span>{{ formatDate($receipt->payment_date) }}</span>
            </div>

            <table class="w-full text-left text-gray-700 mb-8">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">Description</th>
                        <th class="p-2">Qty</th>
                        <th class="p-2">Unit price</th>
                        <th class="p-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">{{ $payment->plan->title }}</td>
                        <td class="p-2 text-left">{{ $payment->attempts_purchased ?? 'N/A' }}</td>
                        <td class="p-2 text-left">{{ formatNaira($payment->amount) }}</td>
                        <td class="p-2 text-right">{{ formatNaira($receipt->amount) }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="flex justify-end text-gray-800">
                <div class="w-1/2">
                    <div class="flex justify-between mb-2">
                        <p>Subtotal</p>
                        <p>{{ formatNaira($receipt->amount) }}</p>
                    </div>
                    <div class="flex justify-between mb-2">
                        <p>Total</p>
                        <p>{{ formatNaira($receipt->amount) }}</p>
                    </div>
                    <div class="flex justify-between font-bold">
                        <p>Amount paid</p>
                        <p>{{ formatNaira($payment->amount) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
