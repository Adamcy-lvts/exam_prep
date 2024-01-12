<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Subject;
use Livewire\Component;
use App\Models\FieldOfStudy;

class SubjectsPage extends Component
{
    public $subjects;

    public function mount($examid, $fieldid)
    {
        //    $studyField = FieldOfStudy::find($id);



        $this->subjects = Subject::where('field_id', $fieldid)->where('exam_id', $examid)->get();
        //    dd($this->subjects);

        //    $this->subjects = $studyField->subjects;
    }
    public function render()
    {
        // $subjects = Course::all();

        return view('livewire.subjects-page', [
            // 'subjects' => $subjects
        ]);
    }
}
