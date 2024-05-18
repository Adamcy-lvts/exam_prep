<x-filament-panels::page>
    <style>
        /* Animation and Transition Styles */
        @keyframes fadeInScaleUp {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes slideInFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        .success-message-box {
            animation: fadeInScaleUp 0.5s ease-out forwards;
        }

        .success-icon {
            animation: pulse 1s infinite;
        }

        .start-next-topic-button:hover {
            background-color: #34d058;
            transition: background-color 0.3s ease;
        }

        .failure-message-box {
            animation: slideInFadeIn 0.5s ease-out forwards;
        }

        .failure-icon {
            animation: shake 0.5s ease-in-out;
        }

        .failure-buttons button:hover {
            background-color: #e3342f;
            transition: background-color 0.3s ease;
        }
    </style>
    <div x-data="{ showQuiz: @entangle('showQuiz'), showSuccessMessage: @entangle('showSuccessMessage'), showFailureMessage: @entangle('showFailureMessage') }">
        <!-- Success Message -->
        <template x-if="showSuccessMessage">
            <div x-show.transition.origin.bottom.duration.500ms="showSuccessMessage"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center px-4 py-4 ">
                <div
                    class="max-w-lg mx-auto bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6 text-center success-message-box">
                    <div class="mb-4">
                        <div class="mx-auto p-3 bg-green-100 dark:bg-green-700 rounded-full inline-block">
                            <svg class="fill-current h-10 w-10 text-center p-1 text-green-600 dark:text-green-400 .success-icon"
                                id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 800 800">
                                <path
                                    d="M36.36,387.88a36.36,36.36,0,0,0,36.37-36.36V206.06c0-73.52,59.81-133.33,133.33-133.33s133.33,59.81,133.33,133.33V315.15h-60.6a36.37,36.37,0,0,0-36.37,36.37V763.64A36.37,36.37,0,0,0,278.79,800H763.64A36.36,36.36,0,0,0,800,763.64V351.52a36.36,36.36,0,0,0-36.36-36.37H412.12V206.06C412.12,92.44,319.68,0,206.06,0S0,92.44,0,206.06V351.52A36.36,36.36,0,0,0,36.36,387.88Z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-md text-green-800   mb-2">
                        Congratulations on passing the quiz on <b>{{ $topic->name }}!</b>
                    </p>
                    <p class="mb-4">
                        You now unlock the next topic: <b>{{ $nextTopicName ?? 'End of the course' }}</b>. Feel free to start reading on {{ $nextTopicName ?? 'End of the course' }}.
                        Continue your learning journey!
                    </p>
                    <button wire:click="continueReading"
                        class=" start-next-topic-button bg-green-300 hover:bg-green-400 text-green-800 dark:text-green-200 dark:bg-green-600 dark:hover:bg-green-500 text-sm font-semibold py-2 px-4 rounded-md transition ease-in-out duration-150 w-full">
                        Start Reading on <b>{{ $nextTopicName ?? 'End of the course' }}</b>
                    </button>
                </div>
            </div>
        </template>

        <!-- Failure Message -->
        <template x-if="showFailureMessage">
            <div x-show.transition.origin.bottom.duration.500ms="showFailureMessage"
                class=" fixed inset-0 bg-gray-600 bg-opacity-50 z-50
                flex items-center justify-center px-4 py-4">
                <div
                    class="max-w-lg mx-auto bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-6 text-center failure-message-box">
                    <div class="mb-4">
                        <div class="mx-auto p-3 bg-red-100 dark:bg-red-700 rounded-full inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" viewBox="0 0 330 330"
                                class="fill-current h-10 w-10 text-center p-1 text-red-600 dark:text-red-400 failure-icon">
                                <!-- SVG path for padlock -->
                                <path
                                    d="M65 330h200c8.284 0 15-6.716 15-15V145c0-8.284-6.716-15-15-15h-15V85c0-46.869-38.131-85-85-85S80 38.131 80 85v45H65c-8.284 0-15 6.716-15 15v170c0 8.284 6.716 15 15 15zm115-95.014V255c0 8.284-6.716 15-15 15s-15-6.716-15-15v-20.014c-6.068-4.565-10-11.824-10-19.986 0-13.785 11.215-25 25-25s25 11.215 25 25c0 8.162-3.932 15.421-10 19.986zM110 85c0-30.327 24.673-55 55-55s55 24.673 55 55v45H110V85z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-md text-red-600 mb-2">
                        Unfortunately, the topic is still locked, you didn't pass the quiz.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        Don't be discouraged. Review the material, fortify your understanding, and prepare to conquer
                        the quiz.
                        {{ $topic->name }} awaits your triumph!
                    </p>
                    <div class="flex flex-col gap-3">
                        <button wire:click="retakeQuiz"
                            class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-2 px-4 rounded-md transition ease-in-out duration-150 w-full failure-message-box">
                            Retake Quiz
                        </button>
                        <button wire:click="continueReading"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 dark:text-gray-200 dark:bg-gray-600 dark:hover:bg-gray-500 text-sm font-semibold failure-message-box
                            py-2 px-4 rounded-md transition ease-in-out duration-150 w-full">
                            Continue Studying
                        </button>
                    </div>
                </div>
            </div>
        </template>
        @if ($showQuiz)

            <div x-show.transition="showQuiz" x-transition:enter="animate__animated animate__fadeIn"
                x-transition:leave="animate__animated animate__fadeOut"
                class="relative bg-white dark:bg-gray-800 rounded-full text-xl font-semibold text-amber-700 dark:text-amber-500 p-3 border border-gray-300 dark:border-gray-700">
                <div class="flex items-center justify-center space-x-2">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-green-600 dark:text-green-400"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            strokeWidth="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0H4z"></path>
                    </svg>
                    <livewire:topic-timer :initialTime="$remainingTime" />
                </div>
            </div>

            <form id="quiz-form" wire:submit.prevent="submitQuiz" class="space-y-10">
                @csrf
                @if ($currentQuestion)
                    <div class="relative p-6 rounded-lg space-y-4 bg-gray-100 dark:bg-gray-800">
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">
                            Question {{ $this->currentQuestionIndex + 1 }}: {{ $currentQuestion->question }}
                        </div>

                        <div class="space-y-4">
                            <!-- Question Options -->
                            @if ($currentQuestion->type == 'mcq')
                                @foreach ($currentQuestion->options as $option)
                                    <label
                                        class="block p-4 rounded-lg hover:bg-blue-50 dark:hover:bg-gray-700 cursor-pointer">

                                        <input type="radio" value="{{ $option->id }}"
                                            class="text-blue-600 focus:ring-blue-500"
                                            wire:click="setAnswer('{{ $currentQuestion->id }}', '{{ $option->id }}')"
                                            wire:model.defer="answers.{{ $currentQuestion->id }}">
                                        <span class="radio-label">{{ chr($loop->index + 65) }}.
                                            {{ $option->option }}</span>
                                    </label>
                                @endforeach
                            @endif
                            <!-- Add other question types like SAQ, TF here -->
                        </div>
                    </div>
                    <!-- Navigation for Next and Previous -->
                    <div class="flex justify-between">
                        @if ($this->currentQuestionIndex <= 0)
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Previous
                            </span>
                        @else
                            <button type="button" wire:click="goToPreviousQuestion"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Previous
                            </button>
                        @endif

                        @if ($this->currentQuestionIndex >= count($this->questionIds) - 1)
                            <!-- Submit button replaces the Next button if on the last question -->
                            <button type="button" wire:click="submitQuiz"
                                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-green-600 border border-transparent leading-5 rounded-md hover:bg-green-700 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                                Submit Quiz
                            </button>
                        @else
                            <!-- Next button is active if not on the last question -->
                            <button type="button" wire:click="goToNextQuestion"
                                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-green-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">

                                Next
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif
                    </div>
                @else
                    <div class="text-center text-gray-500 dark:text-gray-400">No questions available.</div>
                @endif

            </form>
        @endif

</x-filament-panels::page>
