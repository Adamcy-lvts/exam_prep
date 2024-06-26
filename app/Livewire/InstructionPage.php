<?php

namespace App\Livewire;

use App\Models\Subject;
use Livewire\Component;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use App\Models\UserQuizAttempt;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class InstructionPage extends Component
{
    public $userSubjects;
    public $compositeQuizSessionId;
    public $showConfirmationModal;
    public $ongoingAttempt;

    public function mount()
    {
        // Fetch the subjects registered by the user
        $this->userSubjects = Auth::user()->subjects;

        // ... Additional initializations if needed ...
    }

    public function startQuiz()
    {
        $user = Auth::user();
        $compositeSession = $this->createOrRetrieveCompositeSession();

        // Count the number of attempts for this specific composite session
        $attemptCount = UserQuizAttempt::where('user_id', $user->id)
            ->count();
// dd($attemptCount);
        if ($attemptCount >= $compositeSession->allowed_attempts) {
            // Notify the user that they have exhausted their attempts for this session
            Notification::make()
                ->title('No attempts left')
                ->body('You have exhausted your maximum attempts for this quiz session.')
                ->warning()
                ->send();

            return; // Prevent the quiz from starting
        }

        // Record this attempt in UserQuizAttempt
        UserQuizAttempt::create([
            'user_id' => $user->id,
            'composite_quiz_session_id' => $compositeSession->id,
        ]);

        // Continue with the quiz start logic
        return redirect()->route('start.quiz', ['compositeSessionId' => $compositeSession->id]);
    }


    private function createOrRetrieveCompositeSession()
    {
        // Retrieve the latest composite session for the user
        $existingCompositeSession = CompositeQuizSession::where('user_id', Auth::id())
            ->latest('start_time')
            ->first();

        if ($existingCompositeSession && !$existingCompositeSession->completed) {
            // If there's an existing session that is not completed, return it
            return $existingCompositeSession;
        }

        // If no session exists, or the latest session is completed, create a new one
        return CompositeQuizSession::create([
            'user_id' => Auth::id(),
            'start_time' => now(),
            'duration' => 120,
            'end_time' => now()->addMinutes(120), // e.g., 120 minutes for the entire quiz duration
            'allowed_attempts' => 3, // e.g., a user can attempt the quiz 3 times
        ]);
    }



    public function showStartQuizConfirmation()
    {
        // Any preparatory logic before showing the modal goes here

        // Show the modal
        $this->showConfirmationModal = true;
    }

    public function render()
    {
        return view('livewire.instruction-page');
    }
}
