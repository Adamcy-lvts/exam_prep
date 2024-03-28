<x-filament-panels::page>

    <div class="container mx-auto">
        <x-filament::modal id="quiz-instructions-modal" alignment="center" icon="heroicon-o-information-circle"
            width="xl">
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
            <!-- Determine if the topic is unlocked for the user -->

            <!-- Topics Accordion -->
            <div class="space-y-4 mb-4">
                <!-- Single Topic Accordion -->
                <div x-data="{ open: false, init() { this.open = localStorage.getItem('accordion_' + {{ $topic->id }}) === 'true'; } }" x-init="init()" class="w-full">
                    <!-- Accordion Button -->
                    <button @click="open = !open; localStorage.setItem('accordion_' + {{ $topic->id }}, open)"
                        @if ($index > 0 && !$this->isTopicUnlocked($topic->id)) disabled @endif
                        class="w-full flex justify-between items-center bg-white dark:bg-gray-900 rounded-lg px-6 py-4 text-gray-800 dark:text-white font-semibold cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-300 ease-in-out">
                        <span>Topic {{ $index + 1 }}: {{ $topic->name }}</span>
                        <!-- Conditionally render the provided padlock SVG if not the first topic -->
                        @if ($index > 0 && !$this->isTopicUnlocked($topic->id))
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="20" height="20"
                                viewBox="0 0 330 330" class="fill-current text-gray-500 hover:text-green-600"
                                wire:click="handleOpenModal({{ $topic->id }})" {{-- x-on:click="$dispatch('open-modal', { id: 'quiz-instructions-modal', topicId: {{ $topic->id }} })" --}}>
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

                                        </nav>

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
                                            @livewire('chat-component', ['topic' => $topic], key($topic->id))
                                        </div>
                                    </div>
                                    @if (session('message'))
                                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                                            role="alert">
                                            {{ session('message') }}
                                        </div>
                                    @endif

                                    @if (session('error'))
                                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                                            role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                  
                                    @livewire('topic-quiz', ['topic' => $topic], key($topic->id))
                                </div>
                            </div>

                            <!-- Main Content Area -->
                            <div class="w-full md:w-2/3 px-4">
                                <div
                                    class="bg-white dark:bg-gray-900 rounded-xl shadow-xl p-6 border border-gray-300 dark:border-gray-600">

                                    @if ($topic->content)
                                        <div>{!! $topic->content->content !!}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        @endforeach
    </div>

</x-filament-panels::page>
