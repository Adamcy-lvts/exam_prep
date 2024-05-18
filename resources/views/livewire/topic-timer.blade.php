<div wire:ignore x-data="{
    remainingTime: {{ $remainingTime ?? 'null' }},
    intervalId: null,
    hours: 0,
    minutes: 0,
    seconds: 0,
    timerColor: 'text-green-500',

    initTimer() {
        this.clearInterval();
        if (this.remainingTime !== null) {
            this.updateTime();
            this.intervalId = setInterval(() => {
                if (this.remainingTime > 0) {
                    this.remainingTime -= 1000;
                    this.updateTime();
                } else {
                    clearInterval(this.intervalId);
                    this.$dispatch('timesUp'); // This event should be handled in Livewire to submit the question
                }
            }, 1000);
        }
    },

    updateTime() {
        this.seconds = Math.floor(this.remainingTime / 1000) % 60;
        this.minutes = Math.floor(this.remainingTime / (1000 * 60)) % 60;
        this.hours = Math.floor(this.remainingTime / (1000 * 60 * 60));

        // Update timer color based on the remaining time
        if (this.minutes < 2) {
            this.timerColor = 'text-red-600';
        } else if (this.minutes < 5) {
            this.timerColor = 'text-yellow-500';
        } else {
            this.timerColor = 'text-green-500';
        }
    },

    formatTime(unit) {
        return unit.toString().padStart(2, '0');
    },

    clearInterval() {
        if (this.intervalId !== null) {
            clearInterval(this.intervalId);
            this.intervalId = null;
        }
    }

}" x-init="initTimer"
    @reset-timer.window="remainingTime = $event.detail.remainingTime; initTimer()">
    <div class="flex items-center justify-center space-x-2">
        <span>Time left:</span>
        <span x-text="formatTime(hours) + ':' + formatTime(minutes) + ':' + formatTime(seconds)" :class="timerColor"
            class="ml-2 transition-colors duration-500"></span>
    </div>
    

</div>

{{-- <div wire:ignore x-data="{
    remainingTime: {{ $remainingTime }},
    intervalId: null,
    hours: 0,
    minutes: 0,
    seconds: 0,
    timerColor: '',
    updateTimerColor() {
        if (this.minutes < 2) {
            this.timerColor = 'text-red-600';
        } else if (this.minutes < 5) {
            this.timerColor = 'text-amber-500'; // Changed from amber to yellow
        } else {
            this.timerColor = 'text-green-500';
        }
        console.log(this.minutes, this.timerColor); // Debug: Log minutes and color
    }
}" x-init="() => {
    function updateDisplay() {
        remainingTime = remainingTime - 1000;
        seconds = Math.floor(remainingTime / 1000) % 60;
        minutes = Math.floor(remainingTime / (1000 * 60)) % 60;
        hours = Math.floor(remainingTime / (1000 * 60 * 60));

        updateTimerColor();
    }

    updateDisplay();

    intervalId = setInterval(() => {
        if (remainingTime <= 0) {
            clearInterval(intervalId);
            $dispatch('timeUp');
        } else {
            updateDisplay();
        }
    }, 1000);
}">
    <div class="flex items-center justify-center space-x-2">
       
        Time left: <span
            x-text="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`"
            :class="timerColor" class="ml-2 transition-colors duration-500"></span>
    </div>
</div> --}}
