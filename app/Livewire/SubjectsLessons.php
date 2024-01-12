<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;

class SubjectsLessons extends Component
{
    public $subject;

    function mount($id) {
        // dd($id);
        // $this->subject = Subject::find($id);

        $this->subject = Subject::with('topics.subtopics')->find($id);

// dd($this->subject);
    }

    public function render()
    {
        return view('livewire.subjects-lessons');
    }
}
