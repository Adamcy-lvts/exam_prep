<x-filament-panels::page>
    <div class="flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <!-- Header -->
            <div class="bg-green-600 p-6 text-white">
                <h2 class="text-3xl font-bold text-center">JAMB CBT Test Results</h2>
                <p class="text-center mt-2">{{ now()->format('F d, Y') }}</p>
            </div>

            <!-- Candidate Details -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Candidate Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Name:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $compositeSession->user->first_name . ' ' . $compositeSession->user->last_name }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Registration Number:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $compositeSession->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Overall Summary -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Overall Summary</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Questions:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $totalQuestions }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Correct Answers:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $totalCorrectAnswers }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Incorrect Answers:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $totalIncorrectAnswers }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Unanswered Questions:</p>
                        <p class="font-medium text-gray-800 dark:text-gray-200">{{ $totalUnansweredQuestions }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Aggregate Score:</p>
                    <p class="font-medium text-gray-800 dark:text-gray-200">{{ $aggregateScore }} /
                        {{ count($subjectReviews) * 100 }}</p>
                </div>
            </div>

            <!-- Subject Tabs -->
            <div class="p-6">
                <div x-data="{ activeTab: '{{ array_key_first($subjectReviews) }}', showAnswers: false }">
                    <div class="flex space-x-2 mb-4 overflow-x-auto">
                        @foreach ($subjectReviews as $subject => $review)
                            <button @click="activeTab = '{{ $subject }}'"
                                :class="{ 'bg-green-600': activeTab === '{{ $subject }}', 'bg-gray-600': activeTab !== '{{ $subject }}' }"
                                class="px-4 py-2 rounded-lg text-white transition-colors duration-150 whitespace-nowrap">
                                {{ $subject }}
                                <span class="ml-2 bg-gray-700 px-2 py-1 rounded-full text-xs">
                                    {{ $review['score'] }}/100
                                </span>
                            </button>
                        @endforeach
                    </div>
                    @foreach ($subjectReviews as $subject => $review)
                        <div x-show="activeTab === '{{ $subject }}'"
                            class="space-y-4 text-gray-800 dark:text-gray-200">
                            <h3 class="text-xl font-semibold">{{ $subject }} Review</h3>

                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Score:</p>
                                    <p class="font-medium">{{ $review['score'] }}/100</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Correct Answers:</p>
                                    <p class="font-medium">{{ $review['correctAnswers'] }}/50</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Incorrect Answers:</p>
                                    <p class="font-medium">{{ $review['incorrectAnswers'] }}/50</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Performance:</p>
                                <p class="font-medium">{{ $review['performance'] }}</p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Recommendations:</p>
                                <p>{{ $review['recommendations'] }}</p>
                            </div>

                            <div>
                                <button @click="showAnswers = !showAnswers"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4">
                                    <span x-text="showAnswers ? 'Hide' : 'Show'"></span> Answers
                                </button>
                            </div>

                            <div x-show="showAnswers" class="mt-4 max-h-96 overflow-y-auto">
                                <h4 class="text-lg font-semibold mb-2">Questions and Answers:</h4>
                                <ol class="list-decimal pl-5 space-y-4">
                                    @foreach ($review['questions'] as $index => $question)
                                        <li class="border-t border-gray-700 pt-3">
                                            <h5 class="font-medium">{{ $index + 1 }}. {{ $question['question'] }}
                                            </h5>
                                            <ul class="list-none pl-4 mt-2">
                                                @foreach ($question['options'] as $optionIndex => $option)
                                                    <li
                                                        class="
                                                        @if ($option['is_correct'] && $option['id'] == $question['user_answer']) bg-green-600
                                                        @elseif (!$option['is_correct'] && $option['id'] == $question['user_answer']) bg-red-600
                                                        @elseif ($option['is_correct']) bg-green-600 opacity-50 @endif
                                                        p-2 rounded-md mt-1
                                                    ">
                                                        {{ chr(65 + $optionIndex) }}. {{ $option['option'] }}
                                                        @if ($option['is_correct'])
                                                            <span class="ml-2">✓</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if ($question['explanation'])
                                                <p class="mt-2 text-sm text-gray-400">Explanation:
                                                    {{ $question['explanation'] }}</p>
                                            @endif
                                        </li>
                                    @endforeach
                                </ol>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Retake Exam Button -->
        <div class="mt-8 text-center">
            @if ($remainingAttempts > 0)
                <a href="{{ route('filament.user.resources.subjects.jamb-instrcution') }}"
                    class="inline-block bg-green-600 text-white py-3 px-6 rounded-lg text-lg font-semibold cursor-pointer focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 hover:bg-green-700 transition duration-300 ease-in-out shadow-lg hover:shadow-xl">
                    Retake Exam ({{ $remainingAttempts }} Attempts Left)
                </a>
            @else
                <p
                    class="text-xl font-semibold text-gray-700 dark:text-gray-300 bg-yellow-100 dark:bg-yellow-800 p-4 rounded-lg">
                    You have no remaining attempts for this exam.
                </p>
            @endif
        </div>
    </div>
</x-filament-panels::page>
