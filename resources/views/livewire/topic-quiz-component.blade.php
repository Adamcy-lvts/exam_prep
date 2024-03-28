<div>
    <div class="max-w-md mx-auto my-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        @if ($currentQuestion)
            <!-- Question Number and Content -->
            <div class="text-sm font-semibold text-gray-900 dark:text-white mb-4">
                <p>Q{{ $currentQuestionIndex + 1 }}:
                    {{ $currentQuestion->question }}</p>
            </div>
            <!-- Options -->
            <div class="space-y-3">
                @foreach ($currentOptions as $index => $option)
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="radio" name="answer"
                            wire:click="setAnswer('{{ $currentQuestion->id }}', '{{ $option->id }}')"
                            wire:model.defer="answers.{{ $currentQuestion->id }}"
                            class=" h-5 w-5 text-blue-600 rounded-full border-2 border-gray-300 focus:ring-0">
                        <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">
                            {{ chr(65 + $index) }}. {{ $option->option }}
                        </span>
                    </label>
                @endforeach
            </div>
            <!-- Navigation -->
            <div class="flex justify-between items-center mt-6">

                <!-- Previous Button -->
                <button wire:click="goToPreviousQuestion"
                    class="px-4 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-transparent rounded hover:bg-blue-50 dark:hover:bg-gray-700 {{ $currentQuestionIndex <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Previous
                </button>

                <!-- Next Button -->
                <button wire:click="goToNextQuestion"
                    class="px-4 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-transparent rounded hover:bg-blue-50 dark:hover:bg-gray-700 {{ $currentQuestionIndex >= count($questionIds) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Next
                </button>

                <!-- Submit Button -->
                <button wire:click="submitQuiz"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 {{ $currentQuestionIndex < count($questionIds) - 1 ? 'hidden' : '' }}">
                    Submit
                </button>

            </div>
        @endif
    </div>
</div>
