<x-filament-panels::page>
    <div class="flex flex-col items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-lg shadow overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">Exam Results</h2>
                <p class="text-sm text-gray-500 text-center">Candidate Details</p>
                <p class="text-sm text-gray-500 text-center">Name:
                    {{ $compositeSession->user->first_name . ' ' . $compositeSession->user->last_name }}</p>
                <p class="text-sm text-gray-500 text-center">Registration Number: {{ $compositeSession->id }}</p>
            </div>

            <div class="p-5">
                <div class="flex justify-between border-b pb-2">
                    <h3 class="text-lg font-semibold text-gray-600">Subject</h3>
                    <h3 class="text-lg font-semibold text-gray-600">Score</h3>
                </div>
                @foreach ($compositeSession->quizAttempts as $attempt)
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">{{ $attempt->quiz->quizzable->name }}</span>
                        <span class="text-gray-600">{{ $attempt->score }}</span>
                    </div>
                @endforeach
                <div class="flex justify-between pt-2 border-t">
                    <span class="text-lg font-semibold text-gray-600">Aggregate Score</span>
                    <span class="text-lg font-semibold text-gray-600">{{ $aggregateScore }}</span>
                </div>
            </div>
        </div>
        <!-- Retake Exam Button -->
        <div class="mt-6 text-center">
            @if ($remainingAttempts > 0)
                <a href="{{ route('filament.user.resources.subjects.jamb-quiz', ['compositeSessionId' => $compositeSession->id ]) }}"
                    class="inline-block bg-green-600 text-white py-2 px-4 rounded-lg text-sm font-semibold cursor-pointer focus:outline-none focus:ring-2 focus:ring-green-700 focus:ring-opacity-75 hover:bg-green-700 transition duration-300 ease-in-out">
                    Retake Exam ({{ $remainingAttempts }} Attempts Left)
                </a>
            @else
                <p class="text-lg dark:text-gray-300">
                    You have no remaining attempts for this exam.
                </p>
            @endif
        </div>
    </div>
</x-filament-panels::page>
