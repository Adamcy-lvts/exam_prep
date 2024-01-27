<x-filament-panels::page>
    <div class="container mx-auto max-w-6xl flex items-center justify-center">
        <div class="w-full max-w-7xl px-2 sm:px-0" x-data="tabsComponent()">
            <div class="bg-white rounded-lg shadow-md">
                <nav class="flex border-b divide-x divide-gray-300 relative">
                    <!-- Border Slider -->
                    <div class="absolute bottom-0 h-1 bg-green-500 transition duration-300 ease-in-out"
                        :style="{
                            transform: `translateX(${activeTabPosition}px)`,
                            width: `${tabWidth}px`
                        }">
                    </div>
                    <!-- Tab Buttons -->
                    @foreach ($sortedSubjects as $subject)
                        <button @click="setActiveTab($refs['tab-{{ $subject->id }}'], {{ $subject->id }})"
                            x-ref="tab-{{ $subject->id }}"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out"
                            :class="{
                                'text-green-600': activeTab ===
                                    {{ $subject->id }},
                                'text-gray-600 hover:text-green-600': activeTab !==
                                    {{ $subject->id }}
                            }">
                            {{ $subject->name }}
                        </button>
                    @endforeach
                </nav>

                <!-- Tab Contents -->
                <div class="p-4">
                    <form id="test-form" wire:submit.prevent="submitQuiz">
                        @foreach ($sortedSubjects as $subject)
                            <div x-show="activeTab === {{ $subject->id }}">
                                @livewire('subjects-component', ['subjectId' => $subject->id, 'attemptId' => $attempts[$subject->id]], key($subject->id))
                            </div>
                        @endforeach

                        <button type="submit"
                            class="mb-10 w-full sm:w-auto px-6 py-2 text-white rounded-md shadow-md transition-colors duration-150 bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-900 dark:hover:from-gray-600 dark:hover:to-gray-800 dark:focus:ring-blue-300 dark:focus:ring-opacity-50">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>



    </div>

    <script>
        function tabsComponent() {
            return {
                activeTab: {{ $sortedSubjects->first()->id ?? 'null' }},
                activeTabPosition: 0,
                tabWidth: 0,
                setActiveTab(tabElement, subjectId) {
                    this.activeTab = subjectId;
                    this.tabWidth = tabElement.offsetWidth;
                    this.activeTabPosition = tabElement.offsetLeft;
                },
                init() {
                    // Set the initial tab width and position when the component is initialized
                    this.$nextTick(() => {
                        const initialTab = this.$refs[`tab-${this.activeTab}`];
                        if (initialTab) {
                            this.setActiveTab(initialTab, this.activeTab);
                        }
                    });
                }
            };
        }
    </script>
</x-filament-panels::page>
