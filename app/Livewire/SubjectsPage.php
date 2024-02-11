<?php

namespace App\Livewire;

use App\Models\Plan;
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
     
        $basicPlan = Plan::where('title', 'Explorer Access Plan')->first();
        
        if (!$basicPlan) {
            // Handle the case where the basic plan is not found
            // Possibly log an error or set a flash message
            return redirect()->back()->withErrors('Explorer Access Plan not found.');
        }

        $this->user->subjects()->detach();
        $this->user->subjects()->attach($this->selectedSubjects);

        $this->user->registration_status = User::STATUS_REGISTRATION_COMPLETED;
        $this->user->save();

        if (!$this->user->hasInitializedSubjectAttempts()) {
            foreach ($this->user->subjects as $subject) {
                $this->user->subjectAttempts()->create([
                    'subject_id' => $subject->id,
                    'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                ]);
            }
            $this->user->markSubjectAttemptsAsInitialized();
        }
     
        // session()->flash('message', 'Your subjects have been registered successfully.');
        return redirect()->route('filament.user.pages.dashboard');
    }



    public function render()
    {

        return view('livewire.subjects-page', [
            // 'subjects' => $subjects
        ]);
    }
}
