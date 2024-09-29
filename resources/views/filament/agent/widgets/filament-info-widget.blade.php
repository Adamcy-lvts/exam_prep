<x-filament-widgets::widget>
    <x-filament::section>
        @if (auth()->user()->user_type === 'agent' && auth()->user()->agent && auth()->user()->agent->subaccount_code)
            @php
                $normalLink = url('/user/register?ref=' . auth()->user()->agent->referral_code);
                $schoolLink = auth()->user()->agent->schoolRegistrationLinks()->latest()->first();
            @endphp

            <div x-data="{ showSchoolLink: false }" class="">
                @if ($schoolLink && $schoolLink->expires_at->isFuture())
                    <div class="flex items-center justify-between ">
                        <h2 class="text-xs font-semibold">Referral Links</h2>
                        <div class="flex items-center justify-center space-x-2">
                            <input id="linkSwitch" type="checkbox" name="switch" class="hidden" x-model="showSchoolLink">
                            <button x-ref="switchButton" type="button" @click="showSchoolLink = !showSchoolLink"
                                :class="showSchoolLink ? 'bg-blue-600' : 'bg-neutral-200'"
                                class="relative inline-flex h-6 py-0.5 ml-4 focus:outline-none rounded-full w-10"
                                x-cloak>
                                <span :class="showSchoolLink ? 'translate-x-[18px]' : 'translate-x-0.5'"
                                    class="w-5 h-5 duration-200 ease-in-out bg-white rounded-full shadow-md"></span>
                            </button>
                            <label @click="$refs.switchButton.click(); $refs.switchButton.focus()"
                                :class="{ 'text-blue-600': showSchoolLink, 'text-gray-400': !showSchoolLink }"
                                class="text-sm select-none" x-cloak>
                                <span x-text="showSchoolLink ? 'School Link' : 'Individual Link'"></span>
                            </label>
                        </div>
                    </div>
                @else
                    <h2 class="text-xs font-semibold mb-1">Your Referral Link</h2>
                @endif

                <div
                    x-show="!showSchoolLink || !{{ $schoolLink && $schoolLink->expires_at->isFuture() ? 'true' : 'false' }}">
                    <div x-data="{
                        copyText: '{{ $normalLink }}',
                        copyNotification: false,
                        tooltipVisible: false,
                        tooltipText: 'Share this link to invite others and earn rewards',
                        showTooltip() { this.tooltipVisible = true },
                        hideTooltip() { this.tooltipVisible = false },
                        copyToClipboard() {
                            navigator.clipboard.writeText(this.copyText);
                            this.copyNotification = true;
                            setTimeout(() => this.copyNotification = false, 3000);
                        }
                    }" class="flex flex-wrap items-center space-x-2">
                        <div class="relative flex-grow mb-2 sm:mb-0">
                            <a @mouseenter="showTooltip" @mouseleave="hideTooltip" @focus="showTooltip"
                                @blur="hideTooltip" href="{{ $normalLink }}"
                                class="block truncate text-xs text-blue-500 hover:underline">
                                {{ $normalLink }}
                            </a>
                            <div x-show="tooltipVisible" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-1"
                                class="absolute left-1/2 bottom-full mb-2 -translate-x-1/2 z-10" x-cloak>
                                <div class="relative px-2 py-1 text-white bg-gray-900 rounded shadow-lg">
                                    <p x-text="tooltipText" class="text-xs whitespace-nowrap"></p>
                                    <div class="absolute top-full left-1/2 -translate-x-1/2 overflow-hidden">
                                        <div
                                            class="w-2 h-2 transform origin-top-left rotate-45 bg-gray-900 -translate-y-1/2">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button @click="copyToClipboard"
                            class="flex items-center justify-center h-6 px-2 text-xs font-medium bg-white rounded-md cursor-pointer border border-gray-300 hover:bg-gray-50 active:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 text-gray-700 hover:text-gray-900">
                            <svg x-show="!copyNotification" class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <span x-show="!copyNotification" class="text-xs">Copy</span>
                            <svg x-show="copyNotification" class="w-3 h-3 mr-1 text-green-500"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span x-show="copyNotification" class="text-xs text-green-500" x-cloak>Copied</span>
                        </button>
                    </div>
                </div>

                @if ($schoolLink && $schoolLink->expires_at->isFuture())
                    <div x-show="showSchoolLink">
                        <div x-data="{
                            copyText: '{{ route('school.register', ['token' => $schoolLink->token]) }}',
                            copyNotification: false,
                            tooltipVisible: false,
                            tooltipText: 'Share this link with schools to register them under your agency',
                            showTooltip() { this.tooltipVisible = true },
                            hideTooltip() { this.tooltipVisible = false },
                            copyToClipboard() {
                                navigator.clipboard.writeText(this.copyText);
                                this.copyNotification = true;
                                setTimeout(() => this.copyNotification = false, 3000);
                            }
                        }" class="flex flex-wrap items-center space-x-2">
                            <div class="relative flex-grow">
                                <a @mouseenter="showTooltip" @mouseleave="hideTooltip" @focus="showTooltip"
                                    @blur="hideTooltip"
                                    href="{{ route('school.register', ['token' => $schoolLink->token]) }}"
                                    class="block truncate text-xs text-green-500 hover:underline">
                                    {{ route('school.register', ['token' => $schoolLink->token]) }}
                                </a>
                                <div x-show="tooltipVisible" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 translate-y-1"
                                    class="absolute left-1/2 bottom-full mb-2 -translate-x-1/2 z-10" x-cloak>
                                    <div class="relative px-2 py-1 text-white bg-gray-900 rounded shadow-lg">
                                        <p x-text="tooltipText" class="text-xs whitespace-nowrap"></p>
                                        <div class="absolute top-full left-1/2 -translate-x-1/2 overflow-hidden">
                                            <div
                                                class="w-2 h-2 transform origin-top-left rotate-45 bg-gray-900 -translate-y-1/2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button @click="copyToClipboard"
                                class="flex items-center justify-center h-6 px-2 text-xs font-medium bg-white rounded-md cursor-pointer border border-gray-300 hover:bg-gray-50 active:bg-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 text-gray-700 hover:text-gray-900">
                                <svg x-show="!copyNotification" class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span x-show="!copyNotification" class="text-xs">Copy</span>
                                <svg x-show="copyNotification" class="w-3 h-3 mr-1 text-green-500"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span x-show="copyNotification" class="text-xs text-green-500" x-cloak>Copied</span>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Expires: {{ $schoolLink->expires_at->diffForHumans() }}
                        </p>
                    </div>
                @endif
            </div>
        @else
            <div class="space-y-2">
                <h2 class="text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full px-2 py-1 inline-block">
                    Referral Links Pending
                </h2>
                <p class="text-xs text-gray-500">Your referral links are currently being generated. They will appear
                    here
                    once the process is complete.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
