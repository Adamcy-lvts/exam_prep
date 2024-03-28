<?php

namespace App\Livewire;

use Livewire\Component;

class TopicTimer extends Component
{
    public $remainingTime; // In milliseconds
    public $intervalId;
    // protected $listeners = ['timerUpdated'];

    public function mount($initialTime)
    {
        $this->remainingTime = $initialTime;
    }


    public function initializeTimer()
    {
        $this->dispatchBrowserEvent('initialize-timer');
    }
    
    public function render()
    {
        return view('livewire.topic-timer');
    }
}
