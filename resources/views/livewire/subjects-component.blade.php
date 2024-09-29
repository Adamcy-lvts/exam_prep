<div class="py-8 dark:bg-gray-800">
    <div class="container mx-auto px-2 sm:px-4 lg:px-6">
        <!-- Questions -->
        @foreach ($this->questions as $key => $question)
            <div class="mb-8 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-3">
                <p class="text-sm sm:text-lg sm:text-xl text-gray-800 dark:text-gray-200 font-semibold mb-4">
                    <span class="mr-2 text-green-600 dark:text-green-400">Q{{ $this->questions->currentPage() }}.</span>
                    {{ $question->question }}
                </p>
                @if ($question->question_image)
                    <img src="{{ $question->question_image }}" alt="Question Image"
                        class="mb-4 rounded-lg max-w-full h-auto">
                @endif

                <div class="space-y-3">
                    @foreach ($question->options as $option)
                        <label
                            class="flex items-center p-3 rounded-lg transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'bg-green-100 dark:bg-green-800' : '' }}">
                            <input type="radio" value="{{ $option->id }}" class="form-radio text-green-600 mr-3"
                                wire:click="setAnswer({{ $question->id }}, {{ $option->id }})"
                                {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'checked' : '' }}
                                wire:model="answers.{{ $question->id }}">
                            <span class="text-gray-700 dark:text-gray-300 text-base text-sm sm:text-lg flex-grow">
                                <span class="mr-3 font-semibold ">{{ chr($loop->index + 65) }}.</span>
                                {{ $option->option }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        <div class="my-6">
            {{ $questions->links() }}
        </div>

        <!-- Question Navigator -->
        <div class="bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 p-4 mt-8">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Question Navigator</h3>
            <div class="flex flex-wrap gap-2 pl-4 sm:pl-0">
                @foreach ($attemptQuestionIds as $index => $questionId)
                    @php
                        $isAnswered = in_array($questionId, $answeredQuestions);
                        $isActive = $questionId == $currentQuestionId;
                    @endphp
                    <button type="button" wire:click="goToQuestion({{ $index + 1 }})"
                        class="w-10 h-10 rounded-lg text-center items-center flex justify-center text-sm font-medium transition-colors duration-200
                    {{ $isActive ? 'bg-green-600 text-white' : ($isAnswered ? 'bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200') }} 
                    hover:bg-green-500 hover:text-white dark:hover:bg-green-500">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
