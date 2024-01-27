<div>
    <div>
        <!-- Top Bar -->
        <div class="bg-green-600 p-4 text-white flex justify-between items-center mb-24">
            <div>PROSPER</div>
            <div>
                <button class="mr-2">Log Out</button>
                <button class="mr-2">Calculator</button>
                <button class="mr-2">Bookmark</button>
                <button class="mr-2">Report Error</button>
                <button class="mr-2">Dictionary</button>
                <button>Submit</button>
            </div>
            <div>01:59:32</div>
        </div>
        {{-- <div class="container mx-auto max-w-6xl flex items-center justify-center h-screen" x-data="tabComponent()">
            <!-- Tabs -->
            <div class="w-full max-w-7xl px-2 sm:px-0">
                <div class="bg-white rounded-lg shadow-md">
                    <nav class="flex border-b divide-x divide-gray-300 relative">
                        <!-- Border Slider -->
                        <div class="absolute bottom-0 h-1 bg-green-500 transition duration-300 ease-in-out"
                            :style="{ transform: `translateX(${activeTab * 100}%)`, width: `25%` }">
                        </div>

                        <!-- Tab Buttons -->
                        <template x-for="(tab, index) in tabs" :key="index">
                            <button @click="changeTab(index)"
                                :class="{
                                    'text-green-600': activeTab ===
                                        index,
                                    'text-gray-600 hover:text-green-600': activeTab !== index
                                }"
                                class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out"
                                x-text="tab">
                            </button>
                        </template>
                    </nav>

                    <!-- Tab Contents -->
                    <div class="p-4">
                        <div x-show="activeTab === 0">
                            <!-- Question Display -->
                            <div class="p-4">
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold">Question 1/60</div>
                                        <p class="text-gray-700 mt-1">This question is based on S.L. Manyinka's IN
                                            DEPENDENCE...</p>
                                    </div>

                                    <!-- Multiple Choice Options -->
                                    <div class="mb-4">
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>humanitarian</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>hypocritic</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>true belief in christ</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>opportunistic</span>
                                        </label>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex justify-between">
                                        <button
                                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Previous</button>
                                        <button
                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Next</button>
                                    </div>
                                </div>

                                <!-- Question Index -->
                                <div class="flex flex-wrap flex-row gap-2 mt-4">
                                    @for ($n = 1; $n <= 60; $n++)
                                        <div
                                            class="text-center items-center flex justify-center w-10 h-10 bg-white rounded-lg shadow cursor-pointer hover:bg-green-200">
                                            {{ $n }}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div x-show="activeTab === 1" x-cloak>
                            <!-- Content for Physics Tab -->
                           
                        </div>
                        <div x-show="activeTab === 2" x-cloak>
                            <!-- Content for Chemistry Tab -->
                            <p>Content for Chemistry</p>
                        </div>
                        <div x-show="activeTab === 3" x-cloak>
                            <!-- Content for Biology Tab -->
                            <p>Content for Biology</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="container mx-auto max-w-6xl flex items-center justify-center h-screen">
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



{{-- <div class="container mx-auto max-w-6xl">

            <!-- Tabs -->

            <div x-data="{ activeTab: 0 }" class="w-full max-w-7xl px-2 sm:px-0">
                <div class="bg-white rounded-lg shadow-md">
                    <nav class="flex border-b divide-x divide-gray-300">
                        <button @click="activeTab = 0"
                            :class="{
                                'border-b border-blue-500 text-blue-600': activeTab ===
                                    0,
                                'text-gray-600 hover:text-blue-600': activeTab !== 0
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            English
                        </button>
                        <button @click="activeTab = 1"
                            :class="{
                                'border-b border-blue-500 text-blue-600': activeTab ===
                                    1,
                                'text-gray-600 hover:text-blue-600': activeTab !== 1
                            }"
                            class="flex-1 py-4 text-center  focus:outline-none transition duration-150 ease-in-out">
                            Physics
                        </button>
                        <button @click="activeTab = 2"
                            :class="{
                                'border-b border-blue-500 text-blue-600': activeTab ===
                                    2,
                                'text-gray-600 hover:text-blue-600': activeTab !== 2
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Chemistry
                        </button>
                        <button @click="activeTab = 3"
                            :class="{
                                'border-b border-blue-500 text-blue-600': activeTab ===
                                    3,
                                'text-gray-600 hover:text-blue-600': activeTab !== 3
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Biology
                        </button>
                    </nav>

                    <!-- Tab Contents -->
                    <div class="p-4">
                        <div x-show="activeTab === 0">
                            <!-- Question Display -->
                            <div class="p-4">
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    <div class="mb-4">
                                        <div class="text-lg font-semibold">Question 1/60</div>
                                        <p class="text-gray-700 mt-1">This question is based on S.L. Manyinka's IN
                                            DEPENDENCE...</p>
                                    </div>

                                    <!-- Multiple Choice Options -->
                                    <div class="mb-4">
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>humanitarian</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>hypocritic</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>true belief in christ</span>
                                        </label>
                                        <label class="flex items-center mb-2">
                                            <input type="radio" name="answer" class="mr-2">
                                            <span>opportunistic</span>
                                        </label>
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="flex justify-between">
                                        <button
                                            class="bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300">Previous</button>
                                        <button
                                            class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Next</button>
                                    </div>
                                </div>

                                <!-- Question Index -->
                                <div class="flex flex-wrap flex-row gap-2 mt-4">
                                    @for ($n = 1; $n <= 60; $n++)
                                        <div
                                            class="text-center items-center flex justify-center w-10 h-10 bg-white rounded-lg shadow cursor-pointer hover:bg-green-200">
                                            {{ $n }}
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div x-show="activeTab === 1" style="display: none;">
                            <p>Company content...</p>
                        </div>
                        <div x-show="activeTab === 2" style="display: none;">
                            <p>Team Members content...</p>
                        </div>
                        <div x-show="activeTab === 3" style="display: none;">
                            <p>Billing content...</p>
                        </div>
                    </div>
                </div>
            </div>


        </div> --}}

{{-- <div class="container mx-auto max-w-6xl">
            <!-- Tabs -->
            <div x-data="{ activeTab: 0 }" class="w-full max-w-7xl px-2 sm:px-0">
                <div class="bg-white rounded-lg shadow-md">
                    <nav class="flex border-b divide-x divide-gray-300 relative">
                        <!-- Border Slider -->
                        <div class="absolute bottom-0 h-1 bg-green-500 w-1/4"
                            :class="{
                                'transform transition duration-300 ease-in-out': true,
                                'translate-x-0': activeTab === 0,
                                'translate-x-1/4': activeTab === 1,
                                'translate-x-2/4': activeTab === 2,
                                'translate-x-3/4': activeTab === 3
                            }">
                        </div>

                        <!-- Tab Buttons -->
                        <button @click="activeTab = 0"
                            :class="{
                                'text-green-600': activeTab === 0,
                                'text-gray-600 hover:text-green-600': activeTab !== 0
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            English
                        </button>
                        <button @click="activeTab = 1"
                            :class="{
                                'text-green-600': activeTab === 1,
                                'text-gray-600 hover:text-green-600': activeTab !== 1
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Physics
                        </button>
                        <button @click="activeTab = 2"
                            :class="{
                                'text-green-600': activeTab === 2,
                                'text-gray-600 hover:text-green-600': activeTab !== 2
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Chemistry
                        </button>
                        <button @click="activeTab = 3"
                            :class="{
                                'text-green-600': activeTab === 3,
                                'text-gray-600 hover:text-green-600': activeTab !== 3
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Biology
                        </button>
                    </nav>


                    <!-- Tab Contents -->
                    <div class="p-4">
                        <div x-show="activeTab === 0">
                            <!-- Content for English Tab -->
                        </div>
                        <div x-show="activeTab === 1" class="hidden">
                            <!-- Content for Physics Tab -->
                        </div>
                        <div x-show="activeTab === 2" class="hidden">
                            <!-- Content for Chemistry Tab -->
                        </div>
                        <div x-show="activeTab === 3" class="hidden">
                            <!-- Content for Biology Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

{{-- <div class="container mx-auto max-w-6xl">
            <!-- Tabs -->
            <div x-data="{ activeTab: 0 }" class="w-full max-w-7xl px-2 sm:px-0">
                <div class="bg-white rounded-lg shadow-md">
                    <nav class="flex border-b divide-x divide-gray-300 relative">
                        <!-- Border Slider -->
                        <div class="absolute bottom-0 h-1 bg-green-500 transition duration-300 ease-in-out"
                            :style="{ transform: `translateX(${activeTab * 100}%)`, width: `25%` }">
                        </div>

                        <!-- Tab Buttons -->
                        <button @click="activeTab = 0"
                            :class="{
                                'text-green-600': activeTab === 0,
                                'text-gray-600 hover:text-green-600': activeTab !== 0
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            English
                        </button>
                        <button @click="activeTab = 1"
                            :class="{
                                'text-green-600': activeTab === 1,
                                'text-gray-600 hover:text-green-600': activeTab !== 1
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Physics
                        </button>
                        <button @click="activeTab = 2"
                            :class="{
                                'text-green-600': activeTab === 2,
                                'text-gray-600 hover:text-green-600': activeTab !== 2
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Chemistry
                        </button>
                        <button @click="activeTab = 3"
                            :class="{
                                'text-green-600': activeTab === 3,
                                'text-gray-600 hover:text-green-600': activeTab !== 3
                            }"
                            class="flex-1 py-4 text-center focus:outline-none transition duration-150 ease-in-out">
                            Biology
                        </button>
                    </nav>

                    <!-- Tab Contents -->
                    <div class="p-4">
                        <div x-show="activeTab === 0">
                            <!-- Content for English Tab -->
                            <p>Content for English</p>
                        </div>
                        <div x-show="activeTab === 1" class="hidden">
                            <!-- Content for Physics Tab -->
                            <p>Content for Physics</p>
                        </div>
                        <div x-show="activeTab === 2" class="hidden">
                            <!-- Content for Chemistry Tab -->
                            <p>Content for Chemistry</p>
                        </div>
                        <div x-show="activeTab === 3" class="hidden">
                            <!-- Content for Biology Tab -->
                            <p>Content for Biology</p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
