<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Programme;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;

class SubjectsPage extends Component
{
    use WithPagination;

    public $programmes;
    // public $subjects;
    public $selectedProgrammeId = null;
    public $selectedSubjects = [];
    public $user;
    public $examId;
    public $search = '';

    public function mount($examid)
    {
        $this->user = User::find(auth()->id());

        if ($this->user->registration_status === User::STATUS_REGISTRATION_COMPLETED) {
            return redirect()->route('filament.user.pages.dashboard');
        }

        $this->examId = $examid;

        $this->programmes = Programme::with('subjects')->get();
        
    }

    public function toggleProgramme($programmeId)
    {
        if ($this->selectedProgrammeId === $programmeId) {
            $this->selectedProgrammeId = null;
        } else {
            $this->selectedProgrammeId = $programmeId;
        }
    }

    public function toggleSubject($subjectId)
    {
        if (in_array($subjectId, $this->selectedSubjects)) {
            $this->selectedSubjects = array_diff($this->selectedSubjects, [$subjectId]);
        } else if (count($this->selectedSubjects) < 4) {
            $this->selectedSubjects[] = $subjectId;
        }
    }

    public function submitSelection()
    {
        if (count($this->selectedSubjects) < 1) {
            // let's add filament filament error notification and redirect back subject route subject id

           

            Notification::make()
                ->title('Please select at least one subject')
                ->info()
                ->send();
            return  redirect()->route('subjects.page', ['examid' => $this->examId]);
        }

        $basicPlan = Plan::where('title', 'Explorer Access Plan')->first();

        $user = auth()->user();

        // Assign the noun_student role to the user
        $user->assignRole('jamb_student');

        if ($basicPlan) {
            // Create a subscription for the basic plan. Since it's a free plan, you might not set an expiration date,
            // or set a very distant future date if you want to enforce checking subscription validity.
            $user->subscriptions()->create([
                'plan_id' => $basicPlan->id,
                'starts_at' => now(),
                'ends_at' => now()->addYears(10), // Optional: for a free plan, you might not need an expiration.
                'status' => 'active', // Consider your logic for setting status
                'features' => $basicPlan->features // Copying features from plan to subscription
            ]);
        } else {
            // Log error or handle the situation where the Explorer Access Plan doesn't exist.
            Log::error('Explorer Access Plan not found during user registration.', ['user_id' => $user->id]);
        }

        

        if (!$basicPlan) {
            // Handle the case where the basic plan is not found
            // Possibly log an error or set a flash message
          
            return redirect()->back()->withErrors('Explorer Access Plan not found.');
        }

        // Initialize the user's quiz attempts.
        $this->user->jambAttempts()->create([
            'attempts_left' => $basicPlan->number_of_attempts ?? 1 // Number of attempts from the plan
        ]);

        $this->user->subjects()->detach();
        $this->user->subjects()->attach($this->selectedSubjects);
        $this->user->exam_id = $this->examId;
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

       
        Notification::make()
            ->title('Your subjects have been registered successfully.')
            ->success()
            ->send();
        return redirect()->route('filament.user.pages.dashboard');
    }

    public function updatedSearch()
    {
        $this->validate([
            'search' => 'nullable|string|max:255',
        ]);
    }

    public function render()
    {
        //only subjects that are visible
        $subjects = Subject::where('is_visible', 1);

        if (!empty($this->search)) {
            $sanitizedSearch = addslashes($this->search);
            $subjects = $subjects->where('name', 'like', '%' . $sanitizedSearch . '%');
        }

        $subjects = $subjects->paginate(10);

        return view('livewire.subjects-page',[
            'subjects' => $subjects,
        ]);
    }
}
