<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-900 p-6 sm:p-8 rounded-xl shadow-lg mx-auto my-10 max-w-full sm:max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white text-center mb-5">Exam Instructions</h1>

        <div class="dark:bg-gray-800 rounded-lg shadow">
            <div class="bg-white dark:bg-gray-700 rounded-lg p-2 sm:p-6 mb-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">General Instructions</h3>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm sm:text-md space-y-2 mb-4">
                    <li>This is a simulated JAMB CBT (Computer-Based Test) experience.</li>
                    <li>You will be taking four subjects in one sitting.</li>
                    <li>Each subject consists of 50 questions.</li>
                    <li>Total number of questions: 200 (50 per subject).</li>
                    <li>Time allowed: 2 hours for all four subjects.</li>
                    <li>The questions are sourced from:
                        <ul class="list-circle list-inside ml-4 mt-2">
                            <li>Previous JAMB exams</li>
                            <li>AI-generated questions based on the official JAMB syllabus</li>
                        </ul>
                    </li>
                </ul>
                <p class="text-gray-600 dark:text-gray-300 text-sm sm:text-md font-semibold mb-4">
                    Your registered subjects for this exam are:
                </p>
                <ul class="list-disc list-inside text-gray-600 dark:text-gray-300 text-sm sm:text-md mb-4">
                    @foreach ($userSubjects as $subject)
                        <li>{{ $subject->name }}</li>
                    @endforeach
                </ul>
                <div class="bg-yellow-100 dark:bg-yellow-500 border-l-4 border-yellow-500 text-yellow-700 dark:text-yellow-900 p-4 mb-4"
                    role="alert">
                    <p class="font-bold text-sm">Disclaimer:</p>
                    <p class="text-xs">These questions are for practice purposes only. There is no guarantee that these
                        exact questions
                        will appear in your actual JAMB exam. This simulation is designed to provide a realistic JAMB
                        CBT experience and help you prepare for the exam format and time management.</p>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-sm sm:text-md text-gray-500 dark:text-gray-400">Total Time</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">2 Hours</p>
                    </div>
                    <div>
                        <p class="text-sm sm:text-md text-gray-500 dark:text-gray-400">Attempts Remaining</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-white">
                            @if (is_null($user->jambAttempts->attempts_left))
                                Unlimited
                            @elseif($user->jambAttempts->attempts_left > 0)
                                {{ $user->jambAttempts->attempts_left }}
                            @else
                                0
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                @if (!$ongoingSession)
                    <button wire:click="showStartQuizConfirmation"
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50 transition duration-300 ease-in-out shadow hover:shadow-lg text-lg font-semibold">
                        Start Exam
                    </button>
                @else
                    <button wire:click="continueLastAttempt"
                        class="w-full bg-yellow-500 text-white py-3 px-4 rounded-lg hover:bg-yellow-600 focus:outline-none focus:ring-4 focus:ring-yellow-500 focus:ring-opacity-50 transition duration-300 ease-in-out shadow hover:shadow-lg text-lg font-semibold">
                        Continue Last Attempt
                    </button>
                @endif
            </div>
        </div>
    </div>

    <div x-data="{ open: @entangle('showConfirmationModal') }" x-cloak>
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl max-w-md w-full mx-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Start the Exam?</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-6">
                    You're about to start the simulated JAMB CBT Exam for all four subjects. Ensure you're prepared and
                    have
                    reviewed all course materials.
                </p>
                <div class="flex justify-end space-x-4">
                    <button @click="open = false"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 dark:bg-gray-600 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Cancel
                    </button>
                    <button @click="open = false; $wire.startQuiz()"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Yes, Start Exam
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
