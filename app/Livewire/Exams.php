<?php

namespace App\Livewire;

use App\Models\Exam;
use Livewire\Component;

class Exams extends Component
{
    public function render()
    {
        $exams = Exam::all();
        return view('livewire.exams', [
            'exams' => $exams
        ]);
    }
}
