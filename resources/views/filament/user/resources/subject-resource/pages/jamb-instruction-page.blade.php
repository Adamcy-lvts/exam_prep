<x-filament-panels::page>
    <div class="bg-white dark:bg-zinc-800 p-6 sm:p-8 rounded-xl shadow-lg mx-auto my-10 max-w-full sm:max-w-2xl">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white text-center mb-8">JAMB Exam Instructions</h1>

        <div class="bg-green-50 dark:bg-gray-700 rounded-lg p-6 shadow">
            <h2 class="text-xl sm:text-2xl font-semibold text-zinc-900 dark:text-white mb-4">General Instructions</h2>
            <p class="text-zinc-600 dark:text-zinc-300 text-sm sm:text-md mb-4">
                Ensure you have reviewed all course materials thoroughly before attempting the exam. The exam will cover
                the following subjects: Chemistry, Physics, Mathematics, and Use of English.
            </p>
            <div class="flex justify-between items-center mb-6">

                <div>
                    <p class="text-sm sm:text-md text-zinc-500 dark:text-zinc-300">Total Time</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">3 Hours</p>
                    <!-- Example total time for all subjects -->
                </div>
                <div>
                    <p class="text-sm sm:text-md text-zinc-500 dark:text-zinc-300">Attempts Remaining</p>
                    <p class="text-xl font-bold text-zinc-800 dark:text-white">{{ $user->jambAttempts->attempts_left ?? '0' }}
                    </p> <!-- Example attempt count -->
                </div>
            </div>

            <div class="text-center space-y-4">
                @if (!$ongoingSession)
                    <button wire:click="showStartQuizConfirmation"
                        class="w-full bg-green-700 text-white py-3 px-4 rounded-lg hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-700 focus:ring-opacity-50 dark:hover:bg-green-600 transition duration-300 ease-in-out shadow hover:shadow-lg">
                        Start Exam
                    </button>
                @else
                    <button wire:click="continueLastAttempt"
                        class="w-full bg-yellow-500 text-white py-3 px-4 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 dark:hover:bg-yellow-400 transition duration-300 ease-in-out shadow hover:shadow-lg">
                        Continue Last Attempt
                    </button>
                @endif
            </div>
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
</x-filament-panels::page>
