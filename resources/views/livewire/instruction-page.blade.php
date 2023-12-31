<div>
    <div
        class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg mx-auto my-10 max-w-full sm:max-w-md lg:max-w-lg xl:max-w-xl 2xl:max-w-2xl">
        <h1 class="text-xl sm:text-4xl font-extrabold text-gray-900 dark:text-white text-center mb-3">
            Instructions</h1>
        <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white text-center">Comprehensive
            Mathematics
        </h3>
        <div class="text-center my-8">
            <h3 class="text-md sm:text-xl font-semibold mb-2">Exam Instructions</h3>
            <p class="text-gray-600 dark:text-gray-400 md:text-md text-sm mb-4">Ensure you've gone through the course
                material thoroughly
                before attempting this exam.</p>
            <div class="flex justify-center gap-10 mb-4">
                <div>
                    <p class="text-md sm:text-lg text-gray-500 ">Total Questions</p>
                    <p class="text-md sm:text-3xl font-bold text-gray-800 dark:text-white">100</p>
                </div>
                <div>
                    <p class="text-md sm:text-lg text-gray-500">Time</p>
                    <p class="text-md sm:text-3xl font-bold text-gray-800 dark:text-white">2 hours</p>
                </div>
                <div>
                    <p class="text-md sm:text-lg text-gray-500">Attempts</p>
                    <p class="text-md sm:text-3xl font-bold text-gray-800 dark:text-white">1</p>
                </div>
            </div>
            <p class="md:text-md text-sm text-gray-500 dark:text-gray-400">Good luck, and remember to review your
                answers before submitting
                your final exam.</p>
        </div>
        <button wire:click="showStartQuizConfirmation"
            class="w-full bg-green-700 text-white py-2 px-3  sm:py-3 sm:px-4 rounded-md sm:rounded-lg hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-700 focus:ring-opacity-50 dark:hover:bg-green-600 transition duration-300 ease-in-out shadow hover:shadow-lg">
            Start Exam
        </button>
        {{-- <div class="text-center">
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

        </div> --}}
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
                class="bg-white dark:bg-gray-800 p-6 sm:p-8 rounded shadow-lg max-w-full w-full md:w-1/2 lg:w-1/3 relative z-10">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Start the Exam?</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">You're about to start the
                    JAMB Exam. Ensure
                    you're prepared and have reviewed the course material.</p>

                <div class="mt-4 flex justify-end space-x-4">
                    <button @click="open = false; $wire.startQuiz()"
                        class="py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md bg-green-500 hover:bg-green-600 text-white dark:hover:bg-green-700 transition duration-300 ease-in-out">
                        Yes, Start Exam
                    </button>
                    <button @click="open = false"
                        class=" py-1 px-2 text-sm sm:text-md sm:py-2 sm:px-3 rounded-md text-gray-900 bg-gray-900 dark:bg-gray-800 dark:text-white border border-gray-300 dark:border-gray-700 hover:bg-gray-800 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
