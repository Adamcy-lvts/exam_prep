<?php

namespace App\Livewire;

use Livewire\Component;

class SubjectsLessons extends Component
{
    public $subjectID;

    function mount($id) {
        // dd($id);
        $this->subjectID = $id;
    }

    public function render()
    {
        
        return view('livewire.subjects-lessons');
    }
}
