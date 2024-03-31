<x-filament-panels::page>

    <div class="text-center mb-4 px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-4 dark:text-white">
            Customized Attempt Plans
        </h2>
        <p class="text-sm sm:text-md text-gray-600 dark:text-gray-300">
            Select the perfect plan that fits your study needs. From single subject attempts to comprehensive test
            sessions, we've got you covered.
        </p>
    </div>
    <div class="flex flex-col md:flex-row md:space-x-4">
        {{-- {{ dd($user->latestSubscriptionStatus()) }} --}}
        @foreach ($pricingPlans as $plan)
            <div
                class="max-w-sm mx-auto my-4 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 {{ $user->hasActiveSubscription($plan->id) ? 'border-2 border-green-500' : '' }}">
                <h2 class="text-lg font-semibold">{{ $plan->title }}</h2>
                <p class="text-gray-600 dark:text-gray-300 text-sm my-2">
                    {{ $plan->description }}
                </p>
                <div class="my-4">
                    <span class="text-4xl font-bold">{{ formatNaira($plan->price) }}</span>
                    <span class="text-gray-600 dark:text-gray-300 text-base">{{ $plan->currency }}</span>
                </div>

                @if ($user->hasActiveSubscription($plan->id))
                    <div
                        class="text-center p-2 rounded border border-green-600 bg-green-100 text-green-700 dark:border-green-400 dark:bg-green-700 dark:bg-opacity-25 dark:text-green-200">
                        Active Plan
                    </div>
                @elseif ($plan->title === 'Explorer Access Plan')
                    <div class="text-center p-2 rounded border  font-bold text-xl">
                        {{ $plan->cto }}
                    </div>
                @else
                    <div class="flex flex-col">
                        <a href="{{ route('filament.user.resources.subjects.payment-form', $plan->id) }}"
                            class="flex items-center justify-center bg-green-500 text-white p-2 rounded my-8 hover:bg-green-600 transition duration-300 ease-in-out dark:hover:bg-green-800 dark:hover:bg-opacity-25">
                            {{ $plan->cto }}
                        </a>
                    </div>
                @endif




                <ul>
                    @foreach (json_decode($plan->features, true) as $feature)
                        <li class="flex items-center my-2 text-sm">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span>{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>

                <!-- Highlight for active plan -->
                {{-- @if ($user->hasActiveSubscription($plan->id))
                    <div class="text-center p-2 rounded bg-blue-100 text-blue-800">
                        Your Active Plan
                    </div>
                @endif --}}
            </div>
        @endforeach

    </div>

</x-filament-panels::page>
