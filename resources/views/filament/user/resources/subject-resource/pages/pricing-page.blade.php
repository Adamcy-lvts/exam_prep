<x-filament-panels::page>
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Choose Your Plan</h2>
        <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            @foreach ($pricingPlans as $plan)
                <div
                    class="bg-white dark:bg-gray-800 rounded-lg p-8 shadow-sm {{ $user->hasActiveSubscription($plan->id) ? 'border-2 border-green-500' : '' }}">
                    <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">{{ $plan->title }}</h3>
                    <p class="text-3xl font-bold mb-6">{{ formatNaira($plan->price) }}<span
                            class="text-base font-normal">/month</span></p>
                    <ul class="mb-8 space-y-4">
                        @foreach (json_decode($plan->features, true) as $feature)
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    @if ($user->hasActiveSubscription($plan->id))
                        <div class="text-center bg-green-600 text-white rounded-md py-2 px-4 font-semibold">
                            Active Plan
                        </div>
                    @elseif ($plan->title === 'Explorer Access Plan')
                        <div
                            class="text-center bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md py-2 px-4 font-semibold">
                            {{ $plan->cto }}
                        </div>
                    @else
                        <a href="{{ route('filament.user.resources.subjects.payment-form', $plan->id) }}"
                            class="block text-center bg-green-600 text-white rounded-md py-2 px-4 font-semibold hover:bg-green-700 transition duration-300">
                            {{ $plan->cto }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
