<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use Livewire\Component;
use App\Models\FieldOfStudy;
use Illuminate\Support\Facades\Auth;

class SubjectsPage extends Component
{
    public $subjects;
    public $examId;
    public $fieldId;
    public $selectedSubjects = [];
    public $user;

    public function mount($examid, $fieldid)
    {

        $this->subjects = Subject::where('field_id', $fieldid)->where('exam_id', $examid)->get();
        $this->user = auth()->user();
        $this->examId = $examid;
        $this->fieldId = $fieldid;
    }

    public function updatedSelectedSubjects()
    {
        // dd($this->selectedSubjects);
        // This method is automatically called when the selectedSubjects property changes.
        // You can add any additional logic here if needed.
    }

    public function submitSelection()
    {
        // Assuming you have the user available, for example through auth:
        

        // Detach any existing subjects to avoid duplication
        $this->user->subjects()->detach();

        // Attach the new set of selected subjects
        $this->user->subjects()->attach($this->selectedSubjects);

        // Once the user has completed all necessary steps:
        $this->user->registration_status = User::STATUS_REGISTRATION_COMPLETED;
        $this->user->save();

        // Provide some feedback to the user
        $this->redirectRoute('filament.user.pages.dashboard'); 
       
        // session()->flash('message', 'Your subjects have been registered successfully.');

        // Redirect or perform another action as needed
    }


    public function render()
    {

        return view('livewire.subjects-page', [
            // 'subjects' => $subjects
        ]);
    }
}
