<div>
    <!-- Navbar -->

    <div class="min-h-screen px-4 py-10 ">

        <div class="container mx-auto">

            <!-- Lesson Header -->
            <div class="text-center p-8 bg-white dark:bg-gray-900 rounded-xl shadow-xl mb-10">
                <h2 class="text-4xl font-bold text-gray-800 dark:text-white mb-3">{{ $subject->name }} Interactive
                    Lessons for {{ $exam->exam_name }}</h2>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    Click on a topic to expand and explore its lessons. Each module is carefully designed for effective
                    learning and retention to prepare you for the {{ $exam->exam_name }} exams.
                </p>
            </div>


            <div>


                <x-filament::modal id="quiz-instructions-modal" alignment="center" icon="heroicon-o-information-circle"
                    width="xl" :close-by-clicking-away="false">
                    <x-slot name="heading">
                        {{ 'Quiz Instructions' }}
                    </x-slot>

                    <x-slot name="description">
                        <p>
                            To access the content for "{{ $this->clickedTopic->name ?? 'this topic' }}",
                            you must first successfully complete the quiz for
                            "{{ $this->previousTopicName ?? 'the initial topic' }}"
                            with a score of over 50%. This ensures that you have grasped
                            the necessary concepts before moving on to more advanced material.
                        </p>
                    </x-slot>

                    <x-slot name="footer">
                        <div class="flex justify-between">
                            <x-filament::button size="sm" color="danger"
                                x-on:click="$dispatch('close-modal', { id: 'quiz-instructions-modal'})">
                                Close
                            </x-filament::button>

                            <x-filament::button color="primary" wire:click="startQuiz({{ $previousTopicId }})">
                                Start Quiz
                            </x-filament::button>

                        </div>
                    </x-slot>

                </x-filament::modal>

                @foreach ($subject->topics as $index => $topic)
                    {{-- {{dd($topic->content)}} --}}
                    <!-- Topics Accordion -->
                    <div class="space-y-4 mb-4">
                        <!-- Single Topic Accordion -->
                        <div x-data="{ open: false }" class="w-full">
                            <!-- Accordion Button -->

                            <button @click="open = !open" @if ($index > 0) disabled @endif
                                class="w-full flex justify-between items-center bg-white dark:bg-gray-900 rounded-lg px-6 py-4 text-gray-800 dark:text-white font-semibold cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                                <span>Topic {{ $index + 1 }}: {{ $topic->name }}</span>
                                <!-- Conditionally render the provided padlock SVG if not the first topic -->
                                @if ($index > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="20"
                                        height="20" viewBox="0 0 330 330"
                                        class="fill-current text-gray-500 hover:text-green-600"
                                        wire:click="showStartQuizConfirmation" {{-- x-on:click="$dispatch('open-modal', { id: 'quiz-instructions-modal', topicId: {{ $topic->id }} })" --}}>
                                        <path
                                            d="M65 330h200c8.284 0 15-6.716 15-15V145c0-8.284-6.716-15-15-15h-15V85c0-46.869-38.131-85-85-85S80 38.131 80 85v45H65c-8.284 0-15 6.716-15 15v170c0 8.284 6.716 15 15 15zm115-95.014V255c0 8.284-6.716 15-15 15s-15-6.716-15-15v-20.014c-6.068-4.565-10-11.824-10-19.986 0-13.785 11.215-25 25-25s25 11.215 25 25c0 8.162-3.932 15.421-10 19.986zM110 85c0-30.327 24.673-55 55-55s55 24.673 55 55v45H110V85z" />
                                    </svg>
                                @else
                                    <svg :class="{ 'transform rotate-180': open }"
                                        class="w-6 h-6 transition-transform duration-300 ease-in-out" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7">
                                        </path>
                                    </svg>
                                @endif
                            </button>

                            <!-- Accordion Content -->
                            <div x-show="open" x-collapse
                                class="mt-2 bg-white dark:bg-gray-900 rounded-lg shadow-xl p-6 transition duration-300 ease-in-out">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- Learning Objectives Card -->
                                    <div
                                        class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Learning
                                            Objectives
                                        </h3>
                                        @if ($topic->content)
                                            @foreach ($topic->content->learning_objectives as $objective)
                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    {{ $objective }}
                                                </p>
                                            @endforeach
                                        @else
                                            <!-- Handle the case where there is no content -->
                                            <p>No learning objectives available.</p>
                                        @endif


                                    </div>

                                    <!-- Key Concepts Card -->
                                    <div
                                        class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Key
                                            Concepts
                                        </h3>
                                        <ul class="list-disc list-inside text-sm text-gray-600 dark:text-gray-300">
                                            {{-- @foreach ($topic->content->key_concepts as $concept)
                                            <li>{{ $concept }}</li>
                                        @endforeach --}}
                                            @if ($topic->content)
                                                @foreach ($topic->content->key_concepts as $concept)
                                                    <p class="text-sm text-gray-600 dark:text-gray-300">
                                                        {{ $concept }}
                                                    </p>
                                                @endforeach
                                            @else
                                                <!-- Handle the case where there is no content -->
                                                <p>No learning objectives available.</p>
                                            @endif

                                        </ul>
                                    </div>

                                    <!-- Real-World Application Card -->
                                    <div
                                        class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 border border-gray-300 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">Real-World
                                            Application</h3>
                                        {{-- @foreach ($topic->content->real_world_application as $application)
                                        <p class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $application }}
                                        </p>
                                    @endforeach --}}
                                        @if ($topic->content)
                                            @foreach ($topic->content->real_world_application as $application)
                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    {{ $application }}
                                                </p>
                                            @endforeach
                                        @else
                                            <!-- Handle the case where there is no content -->
                                            <p>No learning objectives available.</p>
                                        @endif

                                    </div>
                                </div>

                                <!-- Main Content and Sidebar -->
                                <div class="flex flex-wrap -mx-4 mt-6">
                                    <!-- Sidebar with Subtopics -->
                                    <div class="w-full md:w-1/3 px-4">
                                        <div class="sticky top-0">
                                            <div
                                                class="bg-white dark:bg-gray-900 rounded-xl shadow-xl p-4 border border-gray-300 dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-3">
                                                    Subtopics
                                                </h3>
                                                <nav class="space-y-1 mb-4">
                                                    {{-- @foreach ($topic->subtopics as $subtopic)
                                                    <!-- Subtopic Navigation Links -->
                                                    <a href="#subtopic1"
                                                        class="block text-indigo-500 hover:text-indigo-600 transition-colors duration-200">{{ $subtopic->title }}</a>
                                                @endforeach --}}
                                                </nav>
                                                <!-- Exam Readiness Button -->
                                                {{-- <a href="{{ route('instructions.page') }}"
                                                class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring focus:border-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-800 transition-colors duration-200">
                                                Test Your Readiness
                                            </a> --}}
                                            </div>
                                            <!-- Chat Window Placeholder -->
                                            <div x-data="{ openChat: false }" class="mt-4">
                                                <!-- Chat Button -->
                                                <button @click="openChat = !openChat"
                                                    class="w-full border bg-gray-900 text-gray-200 dark:border-green-400 dark:bg-green-700 dark:bg-opacity-25 dark:text-green-600 focus:ring-2 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center transition-colors duration-200 mb-4">
                                                    Ask any question on {{ $topic->name }}
                                                </button>

                                                <!-- Chat Window -->
                                                <div x-show="openChat" x-collapse
                                                    class="bg-white dark:bg-gray-900 rounded-xl shadow-xl p-4 border border-gray-300 dark:border-gray-600 overflow-hidden transition-all duration-300 ease-in-out">
                                                    @livewire('chat-component', ['topic' => $topic])
                                                </div>
                                            </div>
                                        </div>
                                        

                                    </div>

                                    <!-- Main Content Area -->

                                    {{-- {{dd($content)}} --}}
                                    <div class="w-full md:w-2/3 px-4">
                                        <div
                                            class="bg-white dark:bg-gray-900 rounded-xl shadow-xl p-6 border border-gray-300 dark:border-gray-600">
                                            <!-- Detailed Explanation of Key Concept -->
                                            {{-- <h3>{{ $content->title }}</h3> --}}
                                            @if ($topic->content)
                                                <div>{!! $topic->content->content !!}</div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- @endforeach --}}
                                </div>
                            </div>

                        </div>
                        <!-- Repeat for each topic -->
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    {{-- <div x-data="{ open: @entangle('showConfirmationModal') }" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-in-out duration-500"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in-out duration-500"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 flex items-center justify-center z-[9999]">
            <div
                class="absolute inset-0 bg-black bg-opacity-50 dark:bg-white dark:bg-opacity-30 transition-opacity ease-in-out duration-500">
            </div>

            <!-- Modal -->
            <div
                class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded shadow-lg max-w-full w-full md:w-1/2 lg:w-1/3 relative z-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Instruction</h2>
                <p>
                    To access the content for "{{ $this->clickedTopic->name ?? 'this topic' }}",
                    you must first successfully complete the quiz for
                    "{{ $this->previousTopicName ?? 'the initial topic' }}"
                    with a score of over 50%. This ensures that you have grasped
                    the necessary concepts before moving on to more advanced material.
                </p>

                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="open = false; $wire.startQuiz()"
                        class="py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md bg-green-500 hover:bg-green-600 text-white dark:hover:bg-green-700 transition duration-300 ease-in-out">
                        Yes, Start Exam
                    </button>
                    <button @click="open = false"
                        class=" py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md text-gray-900 bg-gray-900 dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-700 hover:bg-gray-800 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div> --}}
</div>
