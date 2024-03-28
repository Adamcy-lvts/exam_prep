<div>
    <!-- Quiz Section, conditionally displayed -->
    {{-- @if ($showQuiz && $currentTopicId == $topic->id) --}}
    <div x-data="{
        showQuiz: @entangle('showQuiz'),
        currentTopicId: @entangle('currentTopicId'),
        isCurrentTopic: function() {
            return this.showQuiz && this.currentTopicId === {{ $topic->id }};
        }
    }" class="mt-4">
        <!-- Quiz Section -->
        <div x-show="isCurrentTopic()" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden">
                <div class="p-4 border-b border-gray-300 dark:border-gray-600">
                    {{-- <h3
                                                        class="text-lg font-semibold text-gray-800 dark:text-white mb-2">
                                                        Quiz Time</h3> --}}
                    <!-- Timer -->

                    <div x-data="timer()" x-init="startTimer()">
                        <div class="flex items-center justify-center space-x-2">
                            Time left: <span
                                x-text="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`"
                                :class="timerColor" class="font-mono text-lg"></span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <span class="text-xl font-bold"></span>
                    </div>
                </div>
                <div class="mx-auto">
                    <div class="max-w-md mx-auto my-6  p-6 ">
                        @if ($currentQuestion)
                            <!-- Question Number and Content -->
                            <div class="text-sm font-semibold text-gray-900 dark:text-white mb-4">
                                <p>Q{{ $currentQuestionIndex + 1 }}:
                                    {{ $currentQuestion->question }}</p>
                            </div>
                            <!-- Options -->
                            <div class="space-y-3">
                                @foreach ($currentOptions as $index => $option)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="radio" name="answer"
                                            wire:click="setAnswer('{{ $currentQuestion->id }}', '{{ $option->id }}')"
                                            wire:model.defer="answers.{{ $currentQuestion->id }}"
                                            class="h-5 w-5 text-blue-600 rounded-full border-2 border-gray-300 focus:ring-0">
                                        <span class="text-sm sm:text-base text-gray-700 dark:text-gray-300">
                                            {{ chr(65 + $index) }}.
                                            {{ $option->option }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <!-- Navigation -->
                            <div class="flex justify-between items-center mt-6">

                                <!-- Previous Button -->
                                <button wire:click="goToPreviousQuestion"
                                    class="px-4 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-transparent rounded hover:bg-blue-50 dark:hover:bg-gray-700 {{ $currentQuestionIndex <= 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    Previous
                                </button>

                                <!-- Next Button -->
                                <button wire:click="goToNextQuestion"
                                    class="px-4 py-2 text-sm font-semibold text-blue-600 dark:text-blue-400 bg-transparent rounded hover:bg-blue-50 dark:hover:bg-gray-700 {{ $currentQuestionIndex >= count($questionIds) - 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                    Next
                                </button>

                                <!-- Submit Button -->
                                <button wire:click="submitQuiz"
                                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded hover:bg-blue-700 {{ $currentQuestionIndex < count($questionIds) - 1 ? 'hidden' : '' }}">
                                    Submit
                                </button>

                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function timer() {
            return {
                remainingTime: {{ $remainingTime ?? 0 }},
                intervalId: null,
                hours: 0,
                minutes: 0,
                seconds: 0,
                timerColor: 'text-green-500',
                updateTimer() {
                    this.seconds = Math.floor(this.remainingTime / 1000) % 60;
                    this.minutes = Math.floor(this.remainingTime / (60 * 1000)) % 60;
                    this.hours = Math.floor(this.remainingTime / (3600 * 1000));
                    this.timerColor = this.remainingTime <= 120000 ? 'text-red-600' :
                        this.remainingTime <= 300000 ? 'text-amber-500' :
                        'text-green-500';
                },
                startTimer() {
                    this.updateTimer();
                    this.intervalId = setInterval(() => {
                        this.remainingTime -= 1000;
                        this.updateTimer();
                        if (this.remainingTime <= 0) {
                            clearInterval(this.intervalId);
                            this.$dispatch('timeUp');
                            console.log('Time up');
                        }
                    }, 1000);
                },
            }
        }
    </script>
</div>
