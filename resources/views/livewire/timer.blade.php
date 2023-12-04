{{-- <div wire:ignore x-data="{ 
        remainingTime: {{ $remainingTime }}, 
        intervalId: null,
        hours: 0,
        minutes: 0,
        seconds: 0 
     }"
     x-init="() => { 
        console.log('Alpine init with time:', remainingTime);
        
         function updateDisplay() {
             seconds = Math.floor(remainingTime / 1000) % 60;
             minutes = Math.floor(remainingTime / (1000 * 60)) % 60;
             hours = Math.floor(remainingTime / (1000 * 60 * 60));
         }

         updateDisplay();

         intervalId = setInterval(() => {
             if (remainingTime <= 0) {
                 clearInterval(intervalId); 
                 $dispatch('timesUp')
             } else {
                 remainingTime -= 1000; 
                 updateDisplay();
             }
         }, 1000);
     }"
>

    Time left: <span x-text="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`"></span>
</div> --}}

{{-- <div wire:ignore x-data="{
    remainingTime: {{ $remainingTime }},
    intervalId: null,
    hours: 0,
    minutes: 0,
    seconds: 0,
    get timerColor() {
        if (this.minutes < 5) {
            return 'text-red-600';
        } else if (this.minutes < 57) {
            return 'text-amber-500';
        } else {
            return 'text-green-500';
        }
    }
}" x-init="() => {
    function updateDisplay() {
        seconds = Math.floor(remainingTime / 1000) % 60;
        minutes = Math.floor(remainingTime / (1000 * 60)) % 60;
        hours = Math.floor(remainingTime / (1000 * 60 * 60));

        // Update the color based on the remaining time
        $el.classList.remove('text-green-500', 'text-amber-500', 'text-red-600');
        $el.classList.add(this.timerColor);
    }

    updateDisplay();

    intervalId = setInterval(() => {
        if (remainingTime <= 0) {
            clearInterval(intervalId);
            $dispatch('timesUp');
            // Set to red when time is up
            $el.classList.remove('text-green-500', 'text-yellow-500');
            $el.classList.add('text-red-600');
        } else {
            remainingTime -= 1000;
            updateDisplay();
        }
    }, 1000);
}">


    <div class="flex items-center justify-center space-x-2">

        Time left: <span
            x-text="`${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`"
            :class="timerColor"></span>
    </div>

</div> --}}


<div wire:ignore x-data="{
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
            $dispatch('timesUp');
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
</div>
