
    <x-app-layout>
       <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-lg py-24">
           <div class="flex justify-between items-center mb-8">
               <div>
                   <h1 class="font-bold text-xl text-gray-800 dark:text-gray-100 mb-4">Receipt</h1>
                   <p class="text-gray-600 text-sm dark:text-gray-300 mb-2">Receipt number: <span
                           class="font-semibold ">{{ $receipt->receipt_number }}</span></p>
                   <p class="text-gray-600 text-sm dark:text-gray-300 mb-2">Date paid: <span
                           class="font-semibold">{{ formatDate($receipt->payment_date) }}</span>
                   </p>
                   <p class="text-gray-600 text-sm dark:text-gray-300 mb-2">Payment method: <span
                           class="font-semibold">{{ $payment->method }}</span>
                   </p>
               </div>
               <div>
                   <!-- Insert high-resolution company logo here -->
                   <img src="/path-to-your-logo.png" alt="Company Logo" class="h-8 w-auto">
               </div>
           </div>

           <div class="mt-8 text-sm">
               <div class="flex justify-between mb-6">
                   <div class="text-gray-700 dark:text-gray-200">
                       <p class="font-semibold">Devcentric Studio</p>
                       <!-- Replace with your actual address details -->
                       <p>123 Studio Address</p>
                       <p>New York, NY, 10001</p>
                       <p>USA</p>
                       <a href="mailto:studio@example.com"
                           class="text-blue-500 dark:text-blue-400">studio@example.com</a>
                   </div>
                   <div class="text-gray-700 dark:text-gray-200">
                       <p class="font-semibold">Bill to</p>
                       <!-- Replace with actual customer details -->
                       <p>{{ $receipt->user->first_name . ' ' . $receipt->user->last_name }}</p>
                       <p>{{ $receipt->user->email }}</p>
                       <p>{{ $receipt->user->phone }}</p>
                   </div>
               </div>

               <div class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">
                   {{ formatNaira($payment->amount) }} paid on
                   <span>{{ formatDate($receipt->payment_date) }}</span>
               </div>

               <table class="w-full text-left text-gray-700 dark:text-gray-200">
                   <thead>
                       <tr class="bg-gray-100 dark:bg-gray-700">
                           <th class="p-2">Description</th>
                           <th class="p-2">Qty</th>
                           <th class="p-2">Unit price</th>
                           <th class="p-2 text-right">Amount</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td class="p-2">{{ $payment->plan->title }}</td>
                           <td class="p-2 text-left">{{ $payment->attempts_purchased ?? 'N/A' }}</td>
                           <td class="p-2 text-left"> {{ formatNaira($payment->amount) }}</td>
                           <td class="p-2 text-right">{{ formatNaira($receipt->amount) }}</td>
                       </tr>
                   </tbody>
               </table>

               <div class="flex justify-between mt-8 text-gray-800 dark:text-gray-100">
                   <div>
                       <p class="mb-2">Subtotal</p>
                       <p class="mb-2">Total</p>
                       <p class="mb-2">Amount paid</p>
                   </div>
                   <div class="text-right">
                       <p class="mb-2">{{ formatNaira($receipt->amount) }}</p>
                       <p class="mb-2">{{ formatNaira($receipt->amount) }}</p>
                       <p class="mb-2">{{ formatNaira($payment->amount) }}</p>
                   </div>
               </div>
           </div>
       </div>
       {{-- @endsection --}}
  </x-app-layout>
