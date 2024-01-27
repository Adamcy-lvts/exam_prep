<?php

namespace App\Livewire;

use App\Models\Exam;
use Livewire\Component;
use Filament\Notifications\Notification;

class Exams extends Component
{
    public function render()
    {
        // $exams = Exam::all();
        // Only get exams where the name is 'JAMB' or 'NOUN'
        $exams = Exam::whereIn('exam_name', ['JAMB', 'NOUN'])->get();
        // Check for a session message and notify the user
        if (session()->has('message')) {
            $message = session('message');
            Notification::make()->title($message)->warning()->send();
        }
        return view('livewire.exams', [
            'exams' => $exams
        ]);
    }
}
