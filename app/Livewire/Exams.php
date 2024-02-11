<?php

namespace App\Livewire;

use App\Models\Exam;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class Exams extends Component
{

    public $exams;

    public function mount()
    {
        $user = Auth::user();

        if (
            $user && $user->subjects()->count() > 0 || $user && $user->courses()->count() > 0
        ) {
            return redirect()->route('filament.user.pages.dashboard');
        }

        $this->exams = Exam::whereIn('exam_name', ['JAMB', 'NOUN'])->get();
        // Check for a session message and notify the user
        if (session()->has('message')) {
            $message = session('message');
            Notification::make()->title($message)->warning()->send();
        }
    }
    public function render()
    {
        // $exams = Exam::all();
        // Only get exams where the name is 'JAMB' or 'NOUN'


        return view('livewire.exams');
    }
}
