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
            <div
                class="md:hidden bg-white dark:bg-gray-900 fixed bottom-0 left-0 right-0 z-10 p-3 overflow-x-auto shadow-md">
                <div class="flex space-x-3">
                    @foreach ($allquestions as $key => $question)
                        @php
                            $pageNumber = ceil(($key + 1) / 5);
                            $isAnswered = array_key_exists($question->id, $this->answers);
                        @endphp
                        <a href="{{ route('filament.user.resources.courses.questions', ['record' => $quizzable->id, 'quizzableType' => $quizzableType, 'page' => $pageNumber]) . '#q' . ($key + 1) }}"
                            class="text-gray-600 dark:text-gray-300 hover:text-green-500 dark:hover:text-green-400 transition-transform transform hover:scale-105 {{ $isAnswered ? 'bg-green-200 dark:bg-green-700' : '' }} p-2 rounded-md">
                            Q{{ $key + 1 }}
                        </a>
                        @if ($isAnswered)
                            <span
                                class="bg-green-500 dark:bg-green-600 rounded-full h-6 w-6 flex items-center justify-center text-white">
                                ✓
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Main Content and Traditional Sidebar for medium screens and up -->
            <div class="flex flex-1">
                <!-- Traditional Sidebar for Medium Screens and Up -->
                <div
                    class="hidden md:block md:w-1/6 lg:w-1/5 p-6 bg-white dark:bg-gray-900 shadow-lg sticky top-0 overflow-y-auto h-screen">
                    <ul>
                        @foreach ($allquestions as $key => $question)
                            @php
                                $pageNumber = ceil(($key + 1) / 5);
                                $isAnswered = array_key_exists($question->id, $this->answers);
                            @endphp
                            <li class="mb-2 flex items-center">
                                <a href="{{ route('filament.user.resources.courses.questions', ['record' => $quizzable->id, 'quizzableType' => $quizzableType, 'page' => $pageNumber]) . '#q' . ($key + 1) }}"
"
                                    class="text-gray-600 dark:text-gray-300 hover:text-green-500 dark:hover:text-green-400 transition-transform transform hover:scale-105 {{ $isAnswered ? 'bg-green-200 dark:bg-green-700' : '' }} p-2 rounded flex-grow hover:shadow-md">
                                    Question {{ $key + 1 }}
                                </a>
                                @if ($isAnswered)
                                    <span
                                        class="ml-2 bg-green-500 dark:bg-green-600 rounded-full h-6 w-6 flex items-center justify-center text-white">
                                        ✓
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="w-full px-2 md:px-6 md:w-5/6 lg:w-4/5 overflow-y-auto pb-16 mt-5">
                    <form id="test-form" wire:submit.prevent="submitTest">
                        @csrf
                        <div class="space-y-8 mb-10">
                            {{dd($questions->isEmpty())}}
                            @if (!is_null($questions))
                                @foreach ($questions as $key => $question)
                                    @php
                                        $questionNumber = ($questions->currentPage() - 1) * $questions->perPage() + $key + 1;
                                    @endphp
                                    <div id="q{{ $questionNumber }}"
                                        class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-md space-y-4 text-sm sm:text-lg">
                                        <h2 class="g font-medium mb-4 border-b dark:border-gray-600 pb-2">
                                            {{ $questionNumber }}.
                                            {{ $question->question }}</h2>
                                        <div class="space-y-4">
                                            @if ($question->type == \App\Models\Question::TYPE_MCQ)
                                                @foreach ($question->options as $option)
                                                  
                                                    <label class="radio-wrapper">
                                                        <input type="radio" value="{{ $option->id }}"
                                                            class="custom-radio"
                                                            wire:click="setAnswer('{{ $question->id }}', '{{ $option->id }}')"
                                                            wire:model.defer="answers.{{ $question->id }}">
                                                        <span class="radio-label">{{ chr($loop->index + 65) }}.
                                                            {{ $option->option }}</span>
                                                    </label>
                                             
                                                @endforeach
                                            @elseif($question->type == \App\Models\Question::TYPE_SAQ)
                                                <input type="text"
                                                    class="p-2 text-gray-800 rounded border focus:outline-none focus:border-green-500 dark:focus:border-green-400 w-full"
                                                    wire:model="answers.{{ $question->id }}.answer_text"
                                                    wire:change="setAnswer('{{ $question->id }}', null, $event.target.value)">
                                            @elseif($question->type == \App\Models\Question::TYPE_TF)
                                                <label class="flex items-center">
                                                    <input type="radio" value="True" class="mr-2"
                                                        name="tf_{{ $question->id }}"
                                                        wire:model="answers.{{ $question->id }}.answer_text"
                                                        wire:click="setAnswer('{{ $question->id }}', 'True')">
                                                    <span
                                                        class="text-gray-700 dark:text-gray-300">{{ __('True') }}</span>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" value="False" class="mr-2"
                                                        name="tf_{{ $question->id }}"
                                                        wire:model="answers.{{ $question->id }}.answer_text"
                                                        wire:click="setAnswer('{{ $question->id }}', 'False')">
                                                    <span
                                                        class="text-gray-700 dark:text-gray-300">{{ __('False') }}</span>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-center text-gray-500 dark:text-gray-400">No questions available.</p>
                            @endif
                        </div>
                        <button type="submit"
                            class="mb-10 w-full sm:w-auto px-6 py-2 text-white rounded-md shadow-md transition-colors duration-150 bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-600 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-opacity-50 dark:bg-gradient-to-r dark:from-gray-700 dark:to-gray-900 dark:hover:from-gray-600 dark:hover:to-gray-800 dark:focus:ring-blue-300 dark:focus:ring-opacity-50">
                            Submit
                        </button>


                        <!-- Footer with navigation links, save and submit buttons -->
                    </form>
                    {{ $questions->links('vendor.pagination.tailwind') }}
                </div>

            </div>
        </div>

</x-filament-panels::page>
