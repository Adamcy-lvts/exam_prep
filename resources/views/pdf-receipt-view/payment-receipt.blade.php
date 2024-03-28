
    <style>
        .gradient-border {
            background: linear-gradient(to right, #3494E6, #EC6EAD);
            padding: 2px;
        }
    </style>
    <div class="container mx-auto mt-10 p-4">
       
        <!-- Premium Styled Receipt Container -->
        <div class="gradient-border w-full sm:w-2/3 md:w-1/2 lg:w-1/3 mx-auto rounded-lg shadow-lg overflow-hidden">
            <div class="bg-white p-6 rounded-lg">
                <!-- Company Details -->
                <div class="text-center mb-6">
                    <h1 class="text-lg sm:text-2xl font-bold text-gray-700">Devcentric <br>
                        Studio </h1>
                    <p class="text-xs text-gray-600 ">Baga Road Fish Market Layin Budumomi,<br>
                        Maiduguri, Borno State, Nigeria</p>
                    <p class="text-xs text-gray-500">Phone: 07060741999 | 07068189676</p>
                    <div class="text-xs border border-gray-100 my-4"></div>
                </div>

                <!-- Receipt and Transaction Details -->
                <div class="flex flex-row text-sm justify-between mb-2">
                    <span class="text-gray-600 font-semibold mb-2 sm:mb-0">Receipt NO:</span>
                    <span class="text-gray-500"></span>
                </div>

                <div class="flex flex-row text-sm justify-between mb-2">
                    <span class="text-gray-600 font-semibold mb-2 sm:mb-0">Date & Time:</span>
                    <span
                        class="text-gray-500"></span>
                </div>

                <!-- Customer Details -->
                <div class="border-t-2 border-gray-100 pt-4 mb-2">
                    <h2 class="text-center text-md font-semibold mb-2 text-gray-700">Customer Details</h2>
                    <div class="flex flex-row text-sm justify-between">
                        <span class="text-gray-600 font-semibold mb-2 sm:mb-0">Name:</span>
                        <span class="text-gray-500">{{ $payment->user->first_name }}
                            {{ $payment->user->middle_name }} {{ $payment->user->last_name }}</span>
                    </div>
                    <div class="flex flex-row text-sm justify-between mt-2">
                        <span class="text-gray-600 font-semibold mb-2 sm:mb-0">Email:</span>
                        <span class="text-gray-500">{{ $payment->user->email }}</span>
                    </div>
                    <div class="flex flex-row text-sm justify-between mt-2">
                        <span class="text-gray-600 font-semibold mb-2 sm:mb-0">Phone:</span>
                        <span class="text-gray-500">{{ $payment->user->phone }}</span>
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class=" my-2">
                    <h2 class="text-center text-gray-700 text-md font-semibold mb-2">Transaction Details</h2>

                        <!-- Transaction Method -->
                        <div class="flex text-sm text-gray-600 sm:text-md justify-between mb-2">
                            <span class="font-semibold">Method:</span>
                            <span>{{ $payment->method }}</span>
                        </div>

                        <!-- Transaction Amount with emphasized styling -->
                        <div class="flex font-bold mt-2">
                            <span class="text-center w-full px-2">{{ formatNaira($payment->amount) }}</span>
                        </div>

                </div>

            </div>
        </div>
    </div>
