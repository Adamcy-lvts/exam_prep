<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\QuizAnswer;
use App\Models\UserQuizAttempt;
use Filament\Resources\Pages\Page;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\SubjectResource;

class JambInstructionPage extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.jamb-instruction-page';

    public $userSubjects;
    public $compositeQuizSessionId;
    public $showConfirmationModal;
    public $ongoingSession;
    public $compositeSession;
    public $user;

    public function mount(): void
    {
        $this->user = Auth::user();
        static::authorizeResourceAccess();

        $this->userSubjects = Auth::user()->subjects;

        $this->ongoingSession = CompositeQuizSession::where('user_id', auth()->user()->id)
            ->where('completed', 0) // assuming 'completed' is set when the quiz is submitted.
            ->first();

        // dd($this->ongoingSession);
    }

    private function getLatestSession()
    {
        // Returns the latest quiz session for the user and quizzable item.
        return CompositeQuizSession::where('user_id', auth()->user()->id)->latest()->first();
    }

    public function getTitle(): string | Htmlable
    {
        return __('Instructions Page');
    }

    public function startQuiz()
    {

        // Check if the user has an active unlimited plan
        if ($this->user->hasFeature('Unlimited Quiz Attempts for 30 days')) {
            // Proceed with the quiz for users with an unlimited plan
            $this->compositeSession = $this->createOrRetrieveCompositeSession();
            return redirect()->route('filament.user.resources.subjects.jamb-quiz', ['compositeSessionId' => $this->compositeSession->id]);
        }

        // For users without an unlimited plan, check for available attempts
        if ($this->user->hasJambAttempts()) {
            // User has Jamb attempts left, continue with the quiz
            $this->compositeSession = $this->createOrRetrieveCompositeSession();
            return redirect()->route('filament.user.resources.subjects.jamb-quiz', ['compositeSessionId' => $this->compositeSession->id]);
        } elseif ($this->user->hasSubjectAttemptsForAnySubject()) {
            // User has attempts left in other subjects but not for this specific quiz
            Notification::make()
                ->title('No attempts left for this quiz')
                ->body('You have attempts left for other quizzes. Please select another quiz to continue.')
                ->warning()
                ->send();
            return redirect()->route('filament.user.pages.dashboard');
        } else {
            // User has no attempts left in any quiz
            Notification::make()
                ->title('No attempts left')
                ->body('You have exhausted all your attempts, Please purchase more to continue.')
                ->warning()
                ->send();
            return redirect()->route('filament.user.resources.subjects.pricing-page');
        }
    }

 

    public function continueLastAttempt()
    {

        if (auth()->check()) {
            $ongoingSession = $this->ongoingSession;

            if ($ongoingSession) {
                // Find the most recent QuizAnswer for the current session.
                $latestAnswer = QuizAnswer::whereHas('quizAttempt', function ($query) use ($ongoingSession) {
                    $query->where('composite_quiz_session_id', $ongoingSession->id);
                })->latest('updated_at')->first();

                if ($latestAnswer) {
                    // Get the associated attempt and question details from the latest answer.
                    $lastAttemptId = $latestAnswer->quiz_attempt_id;
                    $lastQuestionId = $latestAnswer->question_id;
                    // dd($lastQuestionId);
                    $lastSubjectId = $latestAnswer->question->quizzable_id;

                    session()->forget(['lastAttemptId', 'lastQuestionId', 'lastSubjectId', 'ongoingSessionId']);
                    // Store these details in the session.
                  
                    session([
                        'lastAttemptId' => $lastAttemptId,
                        'lastQuestionId' => $lastQuestionId,
                        'lastSubjectId' => $lastSubjectId,
                        'ongoingSessionId' => $ongoingSession->id
                    ]);

                    // $questionId = session('lastQuestionId');
                    // dd($questionId);
                }
            }
        }

        // Redirect back to the quiz page, which will pick up the session variables.
        return redirect()->route('filament.user.resources.subjects.jamb-quiz', [

            'compositeSessionId' => $ongoingSession->id
        ]);
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
}
