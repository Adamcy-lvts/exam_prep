<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\User;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Programme;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Filament\Notifications\Livewire\Notifications;

class SubjectsPage extends Component
{
    use WithPagination;

    public $programmes;
    public $selectedProgrammeId = null;
    public $selectedSubjects = [];
    public $user;
    public $examId;
    public $search = '';

    public function mount($examid)
    {
        $this->user = User::find(auth()->id());

        // Check if user has 4 subjects registered
        if ($this->user->subjects()->count() >= 4) {
            $this->user->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);
            return redirect()->route('filament.user.pages.dashboard');
        }

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
        $index = array_search($subjectId, $this->selectedSubjects);

        if ($index !== false) {
            // Subject is already selected, so remove it
            unset($this->selectedSubjects[$index]);
            $this->selectedSubjects = array_values($this->selectedSubjects); // Re-index the array
        } else if (count($this->selectedSubjects) < 4) {
            // Subject is not selected and we have less than 4 subjects, so add it
            $this->selectedSubjects[] = $subjectId;
        }
    }

    public function submitSelection()
    {

        // Check if user already has 4 subjects registered
        if ($this->user->subjects()->count() >= 4) {
            $this->user->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);
            Notification::make()
                ->title('You have already registered 4 subjects.')
                ->info()
                ->send();
            return redirect()->route('filament.user.pages.dashboard');
        }

        if (count($this->selectedSubjects) < 1) {
            Notification::make()
                ->title('Please select at least one subject')
                ->info()
                ->send();
            return redirect()->route('subjects.page', ['examid' => $this->examId]);
        }

        $basicPlan = Plan::where('title', 'Free Plan')->firstOrFail();

        // Check for existing subjects
        $existingSubjects = $this->user->subjects()->pluck('subject_id')->toArray();
        $newSubjects = array_diff($this->selectedSubjects, $existingSubjects);

        if (empty($newSubjects)) {
            Log::info('No new subjects to add');
            Notification::make()
                ->title('You have already registered these subjects.')
                ->info()
                ->send();
            return;
        }

        $user = auth()->user();

        // Assign the jamb_student role to the user
        $user->assignRole('jamb_student');

        if ($basicPlan) {
            $user->subscriptions()->create([
                'plan_id' => $basicPlan->id,
                'starts_at' => now(),
                'ends_at' => now()->addYears(10),
                'status' => 'active',
                'features' => $basicPlan->features
            ]);
        } else {
            Log::error('Free Plan not found during user registration.', ['user_id' => $user->id]);
            return redirect()->back()->withErrors('Free Plan not found.');
        }

        // Initialize the user's quiz attempts.
        $this->user->jambAttempts()->create([
            'attempts_left' => $basicPlan->number_of_attempts ?? 1
        ]);

        // Attach new subjects
        $this->user->subjects()->syncWithoutDetaching($newSubjects);
        $this->user->exam_id = $this->examId;

        // Check if user now has 4 or more subjects
        if ($this->user->subjects()->count() >= 4) {
            $this->user->registration_status = User::STATUS_REGISTRATION_COMPLETED;
        }

        $this->user->save();

        if (!$this->user->hasInitializedSubjectAttempts()) {
            foreach ($newSubjects as $subjectId) {
                $this->user->subjectAttempts()->create([
                    'subject_id' => $subjectId,
                    'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                ]);
            }
            $this->user->markSubjectAttemptsAsInitialized();
        }

        Notification::make()
            ->title('Your subjects have been registered successfully.')
            ->success()
            ->send();

        if ($this->user->registration_status === User::STATUS_REGISTRATION_COMPLETED) {
            return redirect()->route('filament.user.pages.dashboard');
        } else {
            return redirect()->route('subjects.page', ['examid' => $this->examId]);
        }
    }

    public function updatedSearch()
    {
        $this->validate([
            'search' => 'nullable|string|max:255',
        ]);
    }

    public function render()
    {
        $subjects = Subject::where('is_visible', 1);

        if (!empty($this->search)) {
            $sanitizedSearch = addslashes($this->search);
            $subjects = $subjects->where('name', 'like', '%' . $sanitizedSearch . '%');
        }

        $subjects = $subjects->paginate(10);

        return view('livewire.subjects-page', [
            'subjects' => $subjects,
        ]);
    }
}
