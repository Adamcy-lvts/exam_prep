<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\FieldOfStudy;
use Livewire\Component;

class StudyFieldPage extends Component
{
    public $studyFields;
    public $examId;

    public function mount($id)
    {
        $this->examId = Exam::find($id);

         $this->studyFields = FieldOfStudy::all();
    }
    public function render()
    {
        return view('livewire.study-field-page');
    }
}
