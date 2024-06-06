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

        <div>
            {{ $questions->links() }}
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
