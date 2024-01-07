<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;

class SubjectsPage extends Component
{
    public function render()
    {
        $subjects = Course::all();
        
        return view('livewire.subjects-page', [
            'subjects' => $subjects
        ]);
    }
}
