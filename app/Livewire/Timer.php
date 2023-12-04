<?php

namespace App\Livewire;

use Livewire\Component;

class Timer extends Component
{
    public $remainingTime; // In milliseconds
    public $intervalId;
    // protected $listeners = ['timerUpdated'];

    public function mount($initialTime)
    {
        $this->remainingTime = $initialTime;

    }
    
    // public function timerUpdated($time)
    // {
        
    //     $this->remainingTime = $time;
    //     // Additional logic to reinitialize or update the timer if needed
    //     // dd($this->remainingTime);
    // }

    public function initializeTimer()
    {
        $this->dispatchBrowserEvent('initialize-timer');
    }


    public function render()
    {
        return view('livewire.timer');
    }
}
