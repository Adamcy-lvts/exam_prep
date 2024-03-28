{{-- <x-filament-panels::page> --}}

<div class="py-8 dark:bg-gray-800">
    <div class="mx-auto">
        <!-- Questions -->
        @foreach ($this->questions as $key => $question)
            <div class="mb-6">
                <p class="text-sm sm:text-lg text-gray-800 dark:text-gray-200 font-semibold mb-3 hover:text-green-600">
                    <span class="mr-2">Q{{ $this->questions->currentPage() }}</span>{{ $question->question }}
                </p>
                @if ($question->question_image)
                    <img src="{{ $question->question_image }}" alt="">
                @endif

                @foreach ($question->options as $option)
                    <label
                        class="flex items-center mb-2 p-3 rounded-lg transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer">
                        <input type="radio" value="{{ $option->id }}" class="form-radio text-green-600 mr-3"
                            wire:click="setAnswer({{ $question->id }}, {{ $option->id }})"
                            {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'checked' : '' }}
                            wire:model.defer="answers.{{ $question->id }}">
                        <span class="text-gray-700 dark:text-gray-300 text-sm sm:text-lg"><span
                                class="mr-3">{{ chr($loop->index + 65) }}.</span>
                            {{ $option->option }}</span>
                    </label>
                @endforeach
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="flex justify-between mt-4">
            @if ($this->questions->previousPageUrl())
                <button type="button" wire:click="previousPage" rel="prev"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </button>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Previous
                </span>
            @endif
            @if ($this->questions->nextPageUrl())
                <button type="button" wire:click="nextPage" rel="next"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:hover:bg-green-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white">
                    Next
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700">
                    Next
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            @endif
        </div>


        <div class="flex flex-wrap flex-row gap-2 mt-4">
            @foreach ($totalQuestions as $index => $question)
                @php
                    $isAnswered = array_key_exists($question->id, $this->answers);
                    $isActive = $questions->currentPage() == $index + 1;
                @endphp
                <div class="text-center items-center flex justify-center w-10 h-10 rounded-lg shadow cursor-pointer hover:bg-gray-200 dark:hover:bg-green-500
            {{ $isActive ? 'bg-green-600 text-white' : 'bg-white dark:bg-gray-700' }} 
            {{ $isAnswered && !$isActive ? 'bg-gray-400' : '' }}
            "
                    wire:click="goToQuestion({{ $index + 1 }})">
                    {{ $index + 1 }}
                </div>
            @endforeach
        </div>

        {{-- Question Navigation --}}

    </div>
</div>



{{-- </x-filament-panels::page> --}}
