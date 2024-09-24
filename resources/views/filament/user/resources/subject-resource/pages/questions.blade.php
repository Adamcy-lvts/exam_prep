<x-filament-panels::page>
    <style>
        /* Custom radio button styling */
        .radio-wrapper {
            display: flex;
            align-items: center;
        }

        .radio-wrapper .custom-radio {
            appearance: none;
            background-color: #fff;
            margin-right: 8px;
            padding: 2px;
            border: 2px solid #bbb;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            outline: none;
            display: grid;
            place-content: center;
        }

        .radio-wrapper .custom-radio:checked {
            border-color: #48bb78;
        }

        .radio-wrapper .custom-radio:after {
            content: '';
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #48bb78;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
        }

        .radio-wrapper .custom-radio:checked:after {
            transform: scale(1);
        }

        .radio-label {
            color: #4a5568;
            font-weight: normal;
            margin: 0;
        }

        /* Dark theme */
        .dark .radio-label {
            color: #e2e8f0;
        }

        .dark .custom-radio {
            background-color: #dce0e7;
        }

        .dark .custom-radio:checked {
            border-color: #48bb78;
        }

        .dark .custom-radio:checked:after {
            background: #48bb78;
        }
    </style>
    <div x-data="{ selectedQuestion: null }" class="bg-gray-100 dark:bg-gray-800 min-h-screen flex flex-col">

        <!-- Timer and Page Header -->
        <!-- Sticky Header with Timer -->
        <div class="sticky top-0 z-50 shadow-md">
            <div class="container mx-auto flex justify-center py-4">
                <div class="relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-gray-800 to-gray-900 opacity-75 rounded-full blur">
                    </div>
                    <div
                        class="relative bg-white dark:bg-gray-800 rounded-full text-xl font-semibold text-red-700 dark:text-red-500 p-3 border border-gray-300 dark:border-gray-700">
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

        <div class="flex flex-1">
            <!-- Responsive Questions Sidebar for small screens -->


            <!-- Main Content and Traditional Sidebar for medium screens and up -->
            <div class="flex flex-1">
                <!-- Enhanced Sidebar for Desktop -->
                <div
                    class="bg-gray-100 dark:bg-gray-800 overflow-y-auto border-r border-gray-200 dark:border-gray-700 hidden md:block">
                    <nav class="mt-5 px-2">
                        <h2
                            class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2 px-3">
                            Questions
                        </h2>
                        <div class="space-y-1 overflow-y-auto">
                            @foreach ($allquestions as $key => $q)
                                @php
                                    $pageNumber = ceil(($key + 1) / 5);
                                    $isAnswered = array_key_exists($q->id, $this->answers);
                                @endphp
                                <a href="{{ route('filament.user.resources.subjects.questions', ['record' => $quizzable->id, 'quizzableType' => $quizzableType, 'page' => $pageNumber]) . '#q' . ($key + 1) }}"
                                    class="group flex items-center px-3 py-2 text-sm font-medium rounded-md transition-colors duration-150 ease-in-out
                                      {{ $loop->iteration == ($questions->currentPage() - 1) * 5 + 1 ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}
                                      {{ $isAnswered ? 'bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200' : '' }}">
                                    Q{{ $key + 1 }}
                                    @if ($isAnswered)
                                        <svg class="ml-2 h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </nav>
                </div>

                <!-- Mobile Questions Navigator -->
                <div class="md:hidden fixed bottom-0 left-0 right-0 bg-gray-100 dark:bg-gray-800 p-2 z-10">
                    <div class="flex overflow-x-auto space-x-2 pb-2">
                        @foreach ($allquestions as $key => $q)
                            @php
                                $pageNumber = ceil(($key + 1) / 5);
                                $isAnswered = array_key_exists($q->id, $this->answers);
                            @endphp
                            <a href="{{ route('filament.user.resources.subjects.questions', ['record' => $quizzable->id, 'quizzableType' => $quizzableType, 'page' => $pageNumber]) . '#q' . ($key + 1) }}"
                                class="flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500
                                  {{ $isAnswered ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300' }}">
                                {{ $key + 1 }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Main Content -->
                <div class="w-full px-2 md:px-6  overflow-y-auto pb-16 mt-5">
                    <form id="test-form" wire:submit.prevent="submitTest">
                        @csrf
                        <div class="space-y-8 mb-10">
                            @if (!is_null($questions))


                                @foreach ($questions as $key => $question)
                                    <div id="q{{ ($questions->currentPage() - 1) * 5 + $loop->iteration }}"
                                        class="bg-white dark:bg-gray-700 shadow sm:rounded-lg overflow-hidden">
                                        <div class="px-4 py-5 sm:p-6">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                                                Question {{ ($questions->currentPage() - 1) * 5 + $loop->iteration }}:
                                                {{ $question->question }}
                                            </h3>
                                            @if ($question->question_image)
                                                <img src="{{ Storage::url($question->question_image) }}"
                                                    alt="Question Image" class="mt-4 max-w-full h-auto rounded-lg">
                                            @endif
                                            <div class="mt-5 space-y-4">
                                                @if ($question->type == \App\Models\Question::TYPE_MCQ)
                                                    @foreach ($question->options as $option)
                                                        <label class="flex items-center space-x-3">
                                                            <input type="radio" name="question_{{ $question->id }}"
                                                                value="{{ $option->id }}"
                                                                class="form-radio h-4 w-4 text-green-600 transition duration-150 ease-in-out"
                                                                wire:click="setAnswer('{{ $question->id }}', '{{ $option->id }}')"
                                                                wire:model.defer="answers.{{ $question->id }}">
                                                            <span
                                                                class="text-gray-700 dark:text-gray-300">{{ chr($loop->index + 65) }}.
                                                                {{ $option->option }}</span>
                                                        </label>
                                                    @endforeach
                                                @elseif($question->type == \App\Models\Question::TYPE_SAQ)
                                                    <input type="text"
                                                        class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"
                                                        wire:model="answers.{{ $question->id }}.answer_text"
                                                        placeholder="Enter your answer here...">
                                                @elseif($question->type == \App\Models\Question::TYPE_TF)
                                                    <div class="flex space-x-4">
                                                        @foreach (['True', 'False'] as $option)
                                                            <label class="flex items-center space-x-3">
                                                                <input type="radio" name="tf_{{ $question->id }}"
                                                                    value="{{ $option }}"
                                                                    class="form-radio h-4 w-4 text-green-600 transition duration-150 ease-in-out"
                                                                    wire:model="answers.{{ $question->id }}.answer_text">
                                                                <span
                                                                    class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-gray-500 dark:text-gray-400">No questions available.</p>
                            @endif
                        </div>
                        {{ $questions->links('vendor.pagination.tailwind') }}
                        <button type="submit"
                            class="mb-10 w-full sm:w-auto px-6 py-2 text-white rounded-md shadow-md transition-colors duration-150 bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-900 dark:hover:from-gray-600 dark:hover:to-gray-800 dark:focus:ring-blue-300 dark:focus:ring-opacity-50">
                            Submit
                        </button>
                        <!-- Footer with navigation links, save and submit buttons -->
                    </form>

                </div>

            </div>
        </div>

</x-filament-panels::page>
