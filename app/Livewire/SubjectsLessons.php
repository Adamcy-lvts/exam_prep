<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\Subject;
use Livewire\Component;

class SubjectsLessons extends Component
{
    public $subject;
    public $examId;
    public $exam;
    public $fieldID;

    function mount($subject_id) {
   
       
        
        $this->subject = Subject::with('topics.subtopics')->find($subject_id);

        $this->exam = $this->subject->exam;
        // $this->examId = 

        // $this->fieldID = $field_id;
    }

    public function render()
    {
        return view('livewire.subjects-lessons');
    }
}
