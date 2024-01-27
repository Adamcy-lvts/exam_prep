<div>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 p-4">
        <div class="w-full max-w-2xl bg-white rounded-lg shadow overflow-hidden">
            <div class="p-5 border-b">
                <h2 class="text-2xl font-semibold text-gray-700 text-center">Quiz Results</h2>
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
            <div class="p-5 border-t flex justify-between items-center">
                <a href="#"
                    class="text-white bg-blue-500 hover:bg-blue-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Continue
                    Reading</a>
                <a href="{{ route('filament.user.pages.dashboard') }}"
                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Go
                    to Dashboard</a>
            </div>
        </div>
    </div>

</div>
