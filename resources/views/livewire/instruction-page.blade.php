<div>
    <div
        class="bg-white dark:bg-zinc-800 p-6 sm:p-8 rounded-xl shadow-lg mx-auto my-10 max-w-full sm:max-w-md lg:max-w-lg xl:max-w-xl 2xl:max-w-2xl">
        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white text-center mb-6">Instructions</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Loop through each subject -->
            @foreach ($userSubjects as $subject)
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 shadow">
                    <h3 class="text-lg sm:text-xl font-semibold text-zinc-900 dark:text-white mb-4">{{ $subject->name }}
                    </h3>
                    <p class="text-zinc-600 dark:text-zinc-300 text-sm mb-4">
                        Review the subject material thoroughly before attempting the exam.
                    </p>
                    <div>
                        <p class="text-sm sm:text-md text-zinc-500 dark:text-zinc-300">Total Questions</p>
                        <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ $subject->questions->count() }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">

            <!-- Handle ongoing attempts -->
            @if (!$ongoingAttempt)
                <button wire:click="showStartQuizConfirmation"
                    class="w-full bg-green-700 text-white py-2 px-3  sm:py-3 sm:px-4 rounded-md sm:rounded-lg hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-700 focus:ring-opacity-50 dark:hover:bg-green-600 transition duration-300 ease-in-out shadow hover:shadow-lg">
                    Start Exam
                </button>
            @else
                <button wire:click="continueLastAttempt"
                    class="w-full bg-green-700 text-white py-2 px-3  sm:py-3 sm:px-4 rounded-md sm:rounded-lg hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-700 focus:ring-opacity-50 dark:hover:bg-green-600 transition duration-300 ease-in-out shadow hover:shadow-lg">
                    Continue Last Attempt
                </button>
            @endif
        </div>
    </div>



    <div x-data="{ open: @entangle('showConfirmationModal') }" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-in-out duration-500"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in-out duration-500"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 flex items-center justify-center z-[9999]">

            <!-- Background overlay -->
            {{-- <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity ease-in-out duration-500"></div> --}}
            <!-- Background overlay -->
            <div
                class="absolute inset-0 bg-black bg-opacity-50 dark:bg-white dark:bg-opacity-30 transition-opacity ease-in-out duration-500">
            </div>


            <!-- Modal -->
            <div
                class="bg-white dark:bg-zinc-800 p-6 sm:p-8 rounded shadow-lg max-w-full w-full md:w-1/2 lg:w-1/3 relative z-10">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Start the Exam?</h2>
                <p class="text-zinc-600 dark:text-zinc-400 mb-4 dark:text-white">You're about to start the
                    JAMB Exam. Ensure
                    you're prepared and have reviewed the course material.</p>

                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="open = false; $wire.startQuiz()"
                        class="py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md bg-green-500 hover:bg-green-600 text-white dark:hover:bg-green-700 transition duration-300 ease-in-out">
                        Yes, Start Exam
                    </button>
                    <button @click="open = false"
                        class=" py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md text-zinc-900 bg-zinc-900 dark:bg-zinc-800 dark:text-white border border-zinc-300 dark:border-zinc-700 hover:bg-zinc-800 dark:hover:bg-zinc-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
