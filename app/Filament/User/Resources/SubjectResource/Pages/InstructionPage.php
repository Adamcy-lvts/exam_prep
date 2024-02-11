<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use App\Filament\Traits\InstructionPageTrait;
use App\Filament\User\Resources\SubjectResource;


class InstructionPage extends Page
{
    use InstructionPageTrait;

    public $user;
    public $course;
    public $courseId;
    public $ongoingAttempt;
    public $existingSession;
    public $allowed_attempts;
    public $numberOfQuestions;
    public $showConfirmationModal;
    public $remainingAttempts;
    public $attempts;
    public $quizzableId;
    public $quizzableType;
    public $quizzable;

    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.instruction-page';

    public $selectedNumberOfQuestions = 20;

    public function mount($record, $quizzableType): void
    {
        $this->user = auth()->user();

        $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $record])->firstOrFail();

        // $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $record])->firstOrFail();
        // Retrieve the latest quiz session for the quizzable item.
        $this->existingSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

        // Get the number of allowed attempts, falling back to the default specified in the quizzable model if not already set in the session.
        $this->allowed_attempts = $this->existingSession->allowed_attempts ?? $this->quizzable->max_attempts;



        // if ($this->user->hasFeature('Flexible quizzes (10-150 questions)')) {
        //     $this->selectedNumberOfQuestions = [ 20, 50, 70, 100, 150];
        // } elseif ($this->user->hasFeature('Flexible quizzes (10-70 questions)')) {
        //     $this->selectedNumberOfQuestions = [ 20, 50, 70];
        // } elseif ($this->user->hasFeature('20 questions per quiz')) {
        //     $this->selectedNumberOfQuestions = [20];
        // }
        // Count the number of questions associated with the quizzable.
        $this->numberOfQuestions = $this->quizzable->questions->count();

        // Initialize attempts to 0.
        $this->attempts = 0;

        // If there is an existing session, try to find an ongoing attempt that has not yet ended.
        if ($this->existingSession !== null) {
            $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_session_id', $this->existingSession->id)->where('quiz_id', $this->quizzable->quizzable_id)
                ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
                ->first();
        }

        // If there is an ongoing attempt, retrieve the selected number of questions and duration from the session.
        if ($this->ongoingAttempt) {
            $this->selectedNumberOfQuestions = session('selectedNumberOfQuestions', $this->selectedNumberOfQuestions); // Default to 100 if not set in session
            $this->duration = session('selectedDuration', $this->quizzable->duration); // Use the quizzable duration as default
        }

        // Count the number of attempts the user has made for this quizzable and session.
        if ($this->existingSession) {
            $this->attempts = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_id', $this->quizzable->id)
                ->where('quiz_session_id', $this->existingSession->id)
                ->count();
        }

        // Update the quiz duration based on the session data.
        $this->updateDuration();
        // dd($this->allowed_attempts);
        // Calculate the remaining attempts by subtracting the number of attempts made from the allowed attempts.
        // $this->remainingAttempts = $this->allowed_attempts - $this->attempts;
        $attempt = $this->user->subjectAttempts()->where('subject_id', $this->quizzable->quizzable_id)->first();
        // $this->remainingAttempts = $attempt ? $attempt->attempts_left : 0;
        $this->remainingAttempts = $attempt ? ($attempt->attempts_left === null ? 'Unlimited' : $attempt->attempts_left) : 0;

    }

    // public function startQuiz()
    // {
    //     // Save the current settings for number of questions and duration to the session.
    //     session([
    //         'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
    //         'selectedDuration' => $this->duration,
    //     ]);


    //     // $planAttempts = $this->user->currentPlan()->number_of_attempts;

    //     // If the user has no attempts left, flash a message and send a notification, then redirect.
    //     if (!$this->user->hasSubjectAttempt($this->quizzable->quizzable_id)) {

    //         Notification::make()->title("You have exhausted your all your attempts, Please Purchase another attempts.")
    //         ->warning()
    //             ->send();
    //         return redirect()->route('filament.user.resources.subjects.pricing-page');
    //     }

    //     // If checks pass,close any confirmation modal and proceed to the quiz questions page.
    //     $this->showConfirmationModal = false;

    //     // Redirect to the quiz questions page with the necessary parameters.
    //     return redirect()->route('filament.user.resources.subjects.questions', [
    //         'record' => $this->quizzable->quizzable_id,
    //         'quizzableType' => $this->quizzable->quizzable_type
    //     ]);
    // }

    public function startQuiz()
    {
        // Save the current settings for number of questions and duration to the session.
        session([
            'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
            'selectedDuration' => $this->duration,
        ]);

        // If the user has an active unlimited plan, proceed to the quiz.
        if ($this->user->hasFeature('Unlimited Quiz Attempts for 30 days')) {
            $this->proceedToQuiz();
            return;
        }

        // Check for subject attempts for the specific quiz.
        if ($this->user->hasSubjectAttempt($this->quizzable->quizzable_id)) {
            $this->proceedToQuiz();
            return;
        }

        // Check if the user has any Jamb attempts left.
        if ($this->user->hasJambAttempts()) {
            // Inform the user they have Jamb attempts left and redirect them to the Jamb instruction page.
            Notification::make()
                ->title("You have Jamb attempts left.")
                ->body("You have exhausted your attempts for this specific subject, but you still have Jamb attempts available.")
                ->warning()
                ->send();
            return redirect()->route('filament.user.resources.subjects.jamb-instrcution');
        } elseif ($this->user->hasSubjectAttemptsForAnySubject()) {
            // Inform the user they have attempts left for other subjects but not for this specific quiz.
            Notification::make()
                ->title("You have no attempts left for this subject.")
                ->body("You have attempts left for other subjects. Please select another subject to continue.")
                ->warning()
                ->send();
            return redirect()->route('filament.user.pages.dashboard');
        } else {
            // The user has no attempts left for any subject or Jamb, redirect to the pricing page.
            Notification::make()
                ->title("You have exhausted all your attempts.")
                ->body("Please purchase more attempts to continue.")
                ->warning()
                ->send();
            return redirect()->route('filament.user.resources.subjects.pricing-page');
        }
    }

    // Helper method to proceed to quiz questions page.
    protected function proceedToQuiz()
    {
        $this->showConfirmationModal = false;
        return redirect()->route('filament.user.resources.subjects.questions', [
            'record' => $this->quizzable->quizzable_id,
            'quizzableType' => $this->quizzable->quizzable_type
        ]);
    }

    public function continueLastAttempt()
    {


        // Redirecting the user based on the last answered question
        if (auth()->check()) {
            // Determine the total number of questions for the quiz
            $totalQuestions = $this->quizzable->questions()->count();

            // Assuming 5 questions per page
            $questionsPerPage = 5;
            $maxPageNumber = ceil($totalQuestions / $questionsPerPage);

            // Check if there's an ongoing attempt for the current user
            $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_id', $this->quizzable->id)
                ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
                ->first();

            // If there's an ongoing attempt
            if ($ongoingAttempt) {
                $lastAnsweredQuestion = QuizAnswer::where('user_id', auth()->user()->id)
                    ->where('quiz_attempt_id', $ongoingAttempt->id)
                    ->latest('created_at')
                    ->first();

                // If the user has answered any questions in the ongoing attempt
                if ($lastAnsweredQuestion) {
                    $pageNumber = ceil($lastAnsweredQuestion->question_id / $questionsPerPage);

                    // Ensure the pageNumber doesn't exceed the maxPageNumber
                    $pageNumber = min($pageNumber, $maxPageNumber);

                    // Check if the current page is different from the page the user should be on
                    if ($this->getPage() != $pageNumber) {
                        // Redirect to the correct page
                        return redirect()->route('filament.user.resources.subjects.questions', [
                            'record' => $this->quizzable->id,
                            'quizzableType' => $this->quizzable->quizzable_type, 'page' => $pageNumber
                        ]);
                    }
                }
            } else {
                // If there's no ongoing attempt, always redirect to the first page
                if ($this->getPage() != 1) {
                    return redirect()->route('filament.user.resources.subjects.questions', [
                        'record' => $this->quizzable->id,
                        'quizzableType' => $this->quizzable->quizzable_type, 'page' => 1
                    ]);
                }
            }
        }
        return redirect()->route('filament.user.resources.subjects.questions', [
            'record' => $this->quizzable->id,
            'quizzableType' => $this->quizzable->quizzable_type
        ]);
    }
}
