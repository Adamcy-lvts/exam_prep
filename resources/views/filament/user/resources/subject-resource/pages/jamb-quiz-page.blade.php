<x-filament-panels::page>
    <style>
        .tab-navigation button:first-of-type {
            border-left-width: 0 !important;
            /* Override any existing left border */
        }

        .tab-navigation button:last-of-type {
            border-right-width: 0 !important;
            /* Override any existing right border */
        }
    </style>
    <div class="sticky top-0 z-50 ">
        <div class="container mx-auto flex justify-center py-4">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-gray-800 to-gray-900 opacity-75 rounded-full blur">
                </div>
                <div
                    class="relative bg-white dark:bg-gray-800 rounded-full text-xl font-semibold text-amber-700 dark:text-amber-500 p-3 border border-gray-300 dark:border-gray-700">
                    <div class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-600 dark:text-green-400"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                strokeWidth="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0H4z"></path>
                        </svg>
                        <livewire:timer :initialTime="$remainingTime" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto max-w-6xl flex items-center justify-center">
        <div class="w-full max-w-7xl px-2 sm:px-4 md:px-6 lg:px-8" x-data="tabsComponent()">
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-md">
                <nav
                    class="flex flex-col sm:flex-row border-b-0 sm:border-b divide-x dark:border-green-600 divide-gray-300 dark:divide-green-500 relative tab-navigation">
                    <!-- Border Slider for non-small screens -->
                    <div class="hidden sm:block absolute bottom-0 h-1 bg-green-500 transition duration-300 ease-in-out"
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
                                'bg-gray-900 sm:bg-transparent': activeTab ==
                                    {{ $subject->id }},
                                'text-green-600': activeTab ==
                                    {{ $subject->id }},
                                'text-gray-600 dark:text-gray-300 hover:text-green-600': activeTab !=
                                    {{ $subject->id }}
                            }">
                            {{ $subject->name }}
                        </button>
                    @endforeach
                </nav>

                <!-- Tab Contents -->
                <div class="p-4">
                    <form id="test-form" wire:submit="submitQuiz">
                        @foreach ($sortedSubjects as $subject)
                            <div x-show="activeTab === {{ $subject->id }}">
                                @livewire('subjects-component', ['subjectId' => $subject->id, 'attemptId' => $attempts[$subject->id]], key($subject->id))
                            </div>
                        @endforeach

                        <button type="submit"
                            class="mb-10 w-full sm:w-auto px-6 py-2 text-white rounded-md shadow-md transition-colors duration-150 bg-gradient-to-r from-green-700 to-green-900 hover:from-green-600 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 dark:bg-gradient-to-r dark:from-green-700 dark:to-green-900 dark:hover:from-green-600 dark:hover:to-green-800 dark:focus:ring-blue-300 dark:focus:ring-opacity-50">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>



    </div>

    <script>
        // function tabsComponent() {
        //     return {
        //         activeTab: {{ $sortedSubjects->first()->id ?? 'null' }},
        //         activeTabPosition: 0,
        //         tabWidth: 0,
        //         setActiveTab(tabElement, subjectId) {
        //             this.activeTab = subjectId;
        //             this.updateTabIndicator(tabElement);
        //         },
        //         updateTabIndicator(tabElement) {
        //             this.tabWidth = tabElement.offsetWidth;
        //             this.activeTabPosition = tabElement.offsetLeft;
        //         },
        //         handleResize() {
        //             const activeTabElement = this.$refs[`tab-${this.activeTab}`];
        //             if (activeTabElement) {
        //                 this.updateTabIndicator(activeTabElement);
        //             }
        //         },
        //         init() {
        //             this.$nextTick(() => {
        //                 this.handleResize();
        //             });
        //             window.addEventListener('resize', () => this.handleResize());
        //         }
        //     };
        // }
        function tabsComponent() {
            return {
                // Initialize activeTab with the ID stored in the session or default to the first subject's ID
                activeTab: {{ session('lastSubjectId', $sortedSubjects->first()->id ?? 'null') }},
                activeTabPosition: 0,
                tabWidth: 0,
                setActiveTab(tabElement, subjectId) {
                    this.activeTab = subjectId;
                    this.updateTabIndicator(tabElement);

                    // Additional code to load the questions for the newly activated subject
                    // and possibly jump to the last question answered within that subject
                    // You would have to trigger a Livewire event or similar here to refresh the questions component
                },
                updateTabIndicator(tabElement) {
                    this.tabWidth = tabElement.offsetWidth;
                    this.activeTabPosition = tabElement.offsetLeft;
                },
                handleResize() {
                    const activeTabElement = this.$refs[`tab-${this.activeTab}`];
                    if (activeTabElement) {
                        this.updateTabIndicator(activeTabElement);
                    }
                },
                init() {
                    this.$nextTick(() => {
                        const activeTabElement = this.$refs[`tab-${this.activeTab}`];
                        if (activeTabElement) {
                            this.setActiveTab(activeTabElement, this.activeTab);
                        }
                        this.handleResize();
                    });
                    window.addEventListener('resize', () => this.handleResize());
                }
            };
        }
    </script>
</x-filament-panels::page>
