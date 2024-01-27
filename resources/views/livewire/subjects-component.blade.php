<div>

    <div class="py-8">
        <div class=" mx-auto ">
            <!-- Questions -->
            @foreach ($this->questions as $key => $question)
                @php
                    $questionNumber = ($questions->currentPage() - 1) * $questions->perPage() + $key + 1;
                @endphp
                <div class="mb-6">
                    <p class="text-lg text-gray-800 font-semibold mb-3">
                        <span class="mr-2">Q{{ $questionNumber }}.</span>{{ $question->question }}</p>
                    @foreach ($question->options as $option)
                        <label
                            class="flex items-center mb-2 p-3 rounded-lg transition-colors duration-200 hover:bg-gray-50 cursor-pointer">
                            <input type="radio" value="{{ $option->id }}" class="form-radio text-green-600 mr-3"
                                wire:click="setAnswer({{ $question->id }}, {{ $option->id }})"
                                {{ isset($answers[$question->id]) && $answers[$question->id] == $option->id ? 'checked' : '' }}
                                wire:model.defer="answers.{{ $question->id }}">
                            <span class="text-gray-700 dark:text-gray-300">{{ chr($loop->index + 65) }}.
                                {{ $option->option }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $questions->links() }}
            </div>

            {{-- Question Navigation --}}
            <div class="flex flex-wrap flex-row gap-2 mt-4">
                @foreach ($allQuestions as $question)
                    <div class="text-center items-center flex justify-center w-10 h-10 bg-white rounded-lg shadow cursor-pointer hover:bg-green-200"
                        wire:click="goToQuestion({{ $loop->iteration }})">
                        {{ $loop->iteration }}
                    </div>
                @endforeach
            </div>

        </div>
    </div>


</div>


{{-- @foreach ($subjects as $index => $subject)
        <div x-show="$wire.activeTab === {{ $index }}">

         

            @foreach ($paginatedQuestions as $question)
                <div class="p-4">
          
                    <div class="text-lg font-semibold">Question
                        {{ $paginatedQuestions->currentPage() }}</div>
                    <p class="text-gray-700 mt-1">{{ $question->question }}</p>

                
                    @foreach ($question->options as $option)
                        <label class="flex items-center">
                            <input type="radio" value="{{ $option->id }}" class="mr-2"
                                wire:click="setAnswer('{{ $subject->id }}','{{ $question->id }}', '{{ $option->id }}')"
                                wire:model.defer="answers.{{ $question->id }}">
                            <span class="text-gray-700 dark:text-gray-300">{{ chr($loop->index + 65) }}.
                                {{ $option->option }}</span>
                        </label>
                    @endforeach

                   
                    <div class="mt-4">
                        {{ $paginatedQuestions->links() }}
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach --}}
