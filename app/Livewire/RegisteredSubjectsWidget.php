<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RegisteredSubjectsWidget extends Widget
{
    protected static string $view = 'livewire.registered-subjects-widget';

    public $subject;
    public $remainingAttempts;

    public function mount($subject)
    {
        $this->subject = $subject;
        $this->loadRemainingAttempts();
    }

    private function loadRemainingAttempts()
    {
        $user = auth()->user();
        $attempt = $user->subjectAttempts()->where('subject_id', $this->subject->id)->first();
        
        $this->remainingAttempts = $attempt ? ($attempt->attempts_left === null ? 'Unlimited' : $attempt->attempts_left) : 0;
    }
}