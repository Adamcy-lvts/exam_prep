<div>

    <div class="text-center mb-4 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-4 dark:text-white">
            Customized Attempt Plans
        </h2>
        <p class="text-md sm:text-lg text-gray-600 dark:text-gray-300">
            Select the perfect plan that fits your study needs. From single subject attempts to comprehensive test
            sessions, we've got you covered.
        </p>
    </div>
    <div class="flex flex-col md:flex-row md:space-x-4">

        <div class="flex flex-col md:flex-row md:space-x-4">
            <!-- Individual Subject Attempt Plan -->
            @foreach ($pricingPlans as $plan)
                <div class="max-w-sm mx-auto my-10 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <h2 class="text-lg font-semibold">{{ $plan->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-300 text-sm my-2">
                        {{ $plan->description }}
                    </p>
                    <div class="my-4">
                        <span class="text-4xl font-bold">{{ $plan->price }}</span>
                        <span class="text-gray-600 dark:text-gray-300 text-base">{{ $plan->currency }}</span>
                    </div>
                    <div class="flex flex-col">
                        <a href="{{ route('filament.user.resources.subjects.payment-form', $plan->id) }}" wire:navigate
                            class="flex items-center justify-center bg-blue-500 text-white p-2 rounded my-8 hover:bg-blue-600 transition duration-300 ease-in-out">
                            {{ $plan->CTO }}
                        </a>
                    </div>

                    <ul>
                        @foreach (json_decode($plan->features, true) as $feature)
                            <div class="flex flex-col text-sm">
                                <li class="flex items-center my-2">
                                    <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ $feature }}</span>
                                </li>

                            </div>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

    </div>


</div>
