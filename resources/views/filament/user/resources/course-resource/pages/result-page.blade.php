<x-filament-panels::page>
    {{-- In your Filament view file --}}
    {{-- 
    <x-result-page-component 
        :questions="$questions" 
        :total-score="$totalScore" 
        :total-marks="$totalMarks" 
        :formatted-time-spent="$formattedTimeSpent" 
        :answered-correct-questions="$answeredCorrectQuestions"
        :answered-wrong-questions="$answeredWrongQuestions" 
        :unanswered-questions="$unansweredQuestions" 
        :quizzable="$quizzable" 
        :remaining-attempts="$remainingAttempts" 
        :organized-performances="$organizedPerformances" 
        :test-answers="$testAnswers" 
    /> --}}

    <div>
        <style>
            @keyframes checkmark {
                0% {
                    stroke-dasharray: 0 100;
                }

                100% {
                    stroke-dasharray: 100 0;
                }
            }

            .animate-checkmark {
                animation: checkmark 2s ease forwards;
            }
        </style>
        <!-- Quiz Completion Message -->
        <div class="text-center">
            <!-- Animated Checkmark -->
            <svg class="w-16 h-16 text-green-500 mx-auto animate-checkmark" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <p class="text-lg font-semibold text-green-500 mt-4 dark:text-green-400">Exam Completed Successfully</p>
        </div>

        <!-- Information Columns -->
        <div
            class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-center text-gray-800 dark:text-gray-200">
            <!-- Total Questions -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; }">
                <div>
                    <p class="text-xl font-semibold">Total Questions</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $questions->count() }}</p>
                </div>
            </div>
            <!-- Score -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; }">
                <div>
                    <p class="text-xl font-semibold">Score</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">
                        {{ $totalScore }}/{{ $totalMarks }}
                    </p>
                </div>
            </div>
            <!-- Time Spent -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; border-radius: 0.5rem !important; }">
                <div>
                    <p class="text-xl font-semibold">Time Spent</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $formattedTimeSpent }}</p>
                </div>
            </div>

            <!-- Correct Answers -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; }">
                <div>
                    <p class="text-xl font-semibold">Correct Answers</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $answeredCorrectQuestions }}</p>
                </div>
            </div>
            <!-- Wrong Answers -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; }">
                <div>
                    <p class="text-xl font-semibold">Wrong Answers</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $answeredWrongQuestions }}</p>
                </div>
            </div>
            <!-- unanswered questions -->
            <div class="p-12 rounded-lg shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 bg-white dark:bg-gray-800 backdrop-blur-md hover:backdrop-blur-lg flex justify-center items-center"
                style=" border: 1px solid transparent; }">
                <div>
                    <p class="text-xl font-semibold">Unanswered Questions</p>
                    <p class="text-3xl font-bold text-green-500 dark:text-green-400">{{ $unansweredQuestions }}</p>
                </div>
            </div>
        </div>


        <!-- Summary Section -->
        <div class="mt-6 text-center">
            <p class="text-xl font-semibold mb-4 dark:text-gray-100">Summary</p>
            <p class="text-lg dark:text-gray-300">
                Congratulations on completing the {{ $quizzable->title }} exam! Your perseverance has paid off, and
                you've gained valuable
                knowledge. Review the topics you excelled at and those requiring more attention to reinforce your
                learning.
            </p>
        </div>

        <!-- Retake Exam Button -->
        <div class="mt-6 text-center">
            @if ($remainingAttempts > 0)
                <a href="{{ route('filament.user.resources.courses.instruction-page', ['record' => $quizzable->quizzable_id, 'quizzableType' => $quizzable->quizzable_type]) }}"
                    class="inline-block bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-semibold cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-opacity-75 hover:bg-green-700 transition duration-300 ease-in-out">
                    Retake Exam ({{ $remainingAttempts }} Attempts Left)
                </a>
            @else
                <p class="text-lg dark:text-gray-300">
                    You have no remaining attempts for this exam.
                </p>
            @endif
        </div>

        <!-- Topics Section -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
            <!-- Topics the User Did Well In -->
            @if ($organizedPerformances->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl transition duration-300">
                    <p class="text-xl font-semibold mb-4 dark:text-gray-100">Topics You Did Well</p>
                    @foreach ($organizedPerformances as $moduleId => $units)
                        @foreach ($units as $unitId => $topics)
                            @php
                                $module = $topics['didWell']->first()->topic->unit->module ?? null;
                                $unit = $topics['didWell']->first()->topic->unit ?? null;
                            @endphp
                            <div class="mb-4">
                                @if ($module)
                                    <div class="text-lg font-bold mb-2">{{ $module->name }}</div>
                                @endif
                                @if ($unit)
                                    <div class="text-md font-semibold mb-1">{{ $unit->name }}</div>
                                @endif
                                <ul class="list-disc list-inside dark:text-gray-300">
                                    @foreach ($topics['didWell'] as $performance)
                                        <li>{{ $performance->topic->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endforeach
                </div>

            @endif

            <!-- Topics the User Didn't Do Well In -->
            @if ($organizedPerformances->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow-xl transition duration-300">
                    <p class="text-xl font-semibold mb-4 dark:text-gray-100">Topics You Didn't Do Well</p>
                    @foreach ($organizedPerformances as $moduleId => $units)
                        @foreach ($units as $unitId => $topics)
                            @php
                                $module = $topics['didNotDoWell']->first()->topic->unit->module ?? null;
                                $unit = $topics['didNotDoWell']->first()->topic->unit ?? null;
                            @endphp
                            <div class="mb-4">
                                @if ($module)
                                    <div class="text-lg font-bold mb-2">{{ $module->name }}</div>
                                @endif
                                @if ($unit)
                                    <div class="text-md font-semibold mb-1">{{ $unit->name }}</div>
                                @endif
                                <ul class="list-disc list-inside dark:text-gray-300">
                                    @foreach ($topics['didNotDoWell'] as $performance)
                                        <li>{{ $performance->topic->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif

        </div>

        <div x-data="{ open: false }" class="w-full mx-auto mt-16">
       
            <!-- Accordion Content -->
            <div x-data="{ open: false }" class="w-full mx-auto mt-16">
                <!-- Accordion Button -->
                <button @click="open = !open"
                    class="flex items-center justify-center w-full bg-green-600 text-white py-2 md:py-4 px-4 md:px-8 rounded-lg text-sm md:text-lg font-semibold cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-opacity-75 hover:bg-green-700 transition duration-300 ease-in-out">
                    <span>View your answers</span>
                    <!-- Icon for accordion state -->
                    <svg :class="{ 'transform rotate-180': open }"
                        class="w-4 h-4 md:w-6 md:h-6 ml-1 md:ml-2 transition-transform duration-300 ease-in-out"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Accordion Content -->
                <div x-show="open" x-collapse
                    class="bg-white dark:bg-gray-900 rounded-lg shadow-xl px-8 py-6 transition duration-300 ease-in-out">
                    <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Answers</h1>
                    <div>
                        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Questions:</h2>
                        <ol class="list-decimal pl-8 space-y-4">
                            @foreach ($questions as $key => $question)
                                <li class="pt-3 border-t border-gray-300 dark:border-gray-700 py-3">
                                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 dark:text-gray-300">
                                        {{ $question->question }}
                                    </h3>
                                    <ol class="list-none pl-4 mt-2 text-sm sm:text-lg">
                                        <!-- Multiple Choice Questions -->
                                        @if ($question->type === 'mcq')
                                            @php $mcqAnswer = $testAnswers->where('question_id', $question->id)->first() @endphp
                                            @foreach ($question->options as $option)
                                                <li
                                                    class="@if ($option->is_correct && $testAnswers->where('question_id', $question->id)->first()->option_id == $option->id) bg-green-100 border border-l-green-600 rounded-md text-green-600 dark:border-green-600 dark:bg-green-700 dark:bg-opacity-25 dark:text-green-400 @elseif (!$option->is_correct && $testAnswers->where('question_id', $question->id)->first()->option_id == $option->id) bg-red-100 border border-l-red-600 rounded-md text-red-600 dark:border-red-600 dark:bg-red-700 dark:bg-opacity-25 dark:text-red-400 @elseif ($option->is_correct) bg-green-100 border border-l-green-600 rounded-md text-green-600 dark:border-green-600 dark:bg-green-700 dark:bg-opacity-25 dark:text-green-400 @elseif ($testAnswers->where('question_id', $question->id)->first()->option_id == $option->id) bg-red-100 dark:bg-red-700 border-red-500 dark:border-red-600 @endif border-l-4 pl-4 py-2 mb-1">
                                                    {{ chr(64 + $loop->index + 1) }}. {{ $option->option }}
                                                    <!-- Show checkmark if option is correct -->
                                                    @if ($option->is_correct)
                                                        <svg class="w-6 h-6 inline-block text-green-500"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @endif
                                                </li>
                                            @endforeach
                                            <!-- Explanation section -->
                                            {{-- @if (auth()->user()->hasFeature('Answer Review and Explanations')) --}}
                                            <div class="mt-4 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                                                <h4
                                                    class="text-md sm:text-lg font-semibold text-gray-900 dark:text-white">
                                                    Answer Explanation:</h4>
                                                <p class="text-sm sm:text-md text-gray-600 dark:text-gray-400">
                                                    {!! $question['explanation'] !!}</p>
                                            </div>
                                            {{-- @endif --}}
                                            @if (!$mcqAnswer || !$mcqAnswer->option_id)
                                                <li
                                                    class="bg-blue-100 dark:bg-blue-700 border-blue-500 dark:border-blue-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                    Unanswered question
                                                </li>
                                            @endif
                                        @elseif ($question->type === 'saq')
                                            @php $saqAnswer = $testAnswers->where('question_id', $question->id)->first() @endphp
                                            @if ($saqAnswer && sanitizeAnswer($saqAnswer->answer_text) === sanitizeAnswer($question->answer_text))
                                                <li
                                                    class="bg-green-100 border border-l-green-600 rounded-md text-green-600 dark:border-green-600 dark:bg-green-700 dark:bg-opacity-25 dark:text-green-400 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                    Answer: {{ $question->answer_text }}
                                                </li>
                                            @elseif (
                                                $saqAnswer->answer_text == !null &&
                                                    sanitizeAnswer($saqAnswer->answer_text) !== sanitizeAnswer($question->answer_text) &&
                                                    $saqAnswer->correct === 0)
                                                <li
                                                    class="bg-red-100 dark:bg-red-700 border-red-500 dark:border-red-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                    Your Answer: {{ $saqAnswer->answer_text }}
                                                </li>
                                                <li
                                                    class="bg-green-100 dark:bg-green-700 border-green-500 dark:border-green-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                    Correct Answer: {{ $question->answer_text }}
                                                </li>
                                            @else
                                                @if (!$saqAnswer || !$saqAnswer->answer_text)
                                                    <li
                                                        class="bg-blue-100 dark:bg-blue-700 border-blue-500 dark:border-blue-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                        Answer: Unanswered
                                                    </li>
                                                    <li
                                                        class="bg-green-100 dark:bg-green-700 border-green-500 dark:border-green-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                        Correct Answer: {{ $question->answer_text }}
                                                    </li>
                                                @endif
                                                {{-- @else --}}
                                            @endif
                                            {{-- True or False Questions --}}
                                        @elseif($question->type === 'tf')
                                            @php $tfAnswer = $testAnswers->where('question_id', $question->id)->first() @endphp
                                            {{-- Display radio buttons reflecting the correct answer --}}
                                            <li>
                                                <label class="flex items-center">
                                                    <input class="text-green-600" type="radio" value="True"
                                                        class="mr-2" disabled
                                                        @if (strtolower($question->answer_text) === 'true') checked @endif>
                                                    <span class="text-gray-700 dark:text-gray-300">True</span>
                                                    <svg class="w-6 h-6 inline-block text-green-500 ml-2"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </label>
                                                <label class="flex items-center">
                                                    <input type="radio" value="False" class="mr-2" disabled
                                                        @if (strtolower($question->answer_text) === 'false') checked @endif>
                                                    <span class="text-gray-700 dark:text-gray-300">False</span>
                                                </label>
                                            </li>
                                            {{-- Check if the question is answered --}}
                                            @if (!$tfAnswer || $tfAnswer->answer_text === null)
                                                {{-- Unanswered Question --}}
                                                <li
                                                    class="bg-blue-100 dark:bg-blue-700 border-blue-500 dark:border-blue-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                    Answer: Unanswered
                                                </li>
                                            @else
                                                {{-- Indicate if the user's answer is correct or not --}}
                                                <li
                                                    class="@if (strtolower($tfAnswer->answer_text) === strtolower($question->answer_text)) bg-green-100 dark:bg-green-700 border-green-500 dark:border-green-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200 @else bg-red-100 dark:bg-red-700 border-red-500 dark:border-red-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200 @endif ">
                                                    Your Answer: {{ $tfAnswer->answer_text }}
                                                    @if (strtolower($tfAnswer->answer_text) === strtolower($question->answer_text))
                                                        (Correct)
                                                    @else
                                                        (Incorrect)
                                                    @endif
                                                </li>
                                                {{-- If the user's answer is incorrect, display the correct answer --}}
                                                @if (strtolower($tfAnswer->answer_text) !== strtolower($question->answer_text))
                                                    <li
                                                        class="bg-green-100 dark:bg-green-700 border-green-500 dark:border-green-600 border-l-4 pl-4 py-2 mb-1 text-gray-900 dark:text-gray-200">
                                                        Correct Answer: {{ $question->answer_text }}
                                                    </li>
                                                @endif
                                            @endif
                                        @endif



                                    </ol>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>


        </div>

</x-filament-panels::page>
