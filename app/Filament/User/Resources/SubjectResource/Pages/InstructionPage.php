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

    public $selectedNumberOfQuestions = 50;

    public function mount($record, $quizzableType): void
    {
        $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $record])->firstOrFail();

        // $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $record])->firstOrFail();
        // Retrieve the latest quiz session for the quizzable item.
        $this->existingSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

        // Get the number of allowed attempts, falling back to the default specified in the quizzable model if not already set in the session.
        $this->allowed_attempts = $this->existingSession->allowed_attempts ?? $this->quizzable->max_attempts;

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
            $this->selectedNumberOfQuestions = session('selectedNumberOfQuestions', 100); // Default to 100 if not set in session
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
        $this->remainingAttempts = $this->allowed_attempts - $this->attempts;

    }

    public function startQuiz()
    {
        // Save the current settings for number of questions and duration to the session.
        session([
            'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
            'selectedDuration' => $this->duration,
        ]);

        // If the user has no attempts left, flash a message and send a notification, then redirect.
        if (!$this->canAttemptQuiz()) {
            session()->flash('success_message', "You have exhausted your maximum of " . $this->allowed_attempts . " attempts for this quiz.");
            Notification::make()->title("You have exhausted your maximum of " . $this->allowed_attempts . " attempts for this quiz.")
            ->warning()
                ->send();
            return redirect()->route('filament.user.resources.subjects.instruction-page', [
                'record' => $this->quizzable->quizzable_id,
                'quizzableType' => $this->quizzable->quizzable_type
            ]);
        }
        // Verify if the quiz can be started based on additional conditions.
        $canStart = $this->canStartQuiz();
        if (!$canStart['status']) {
            // If conditions fail, set an error message and redirect to the dashboard.
            session()->flash('error_message', $canStart['message']);
            return redirect()->route('filament.user.resources.subjects.instruction-page', [
                'record' => $this->quizzable->quizzable_id,
                'quizzableType' => $this->quizzable->quizzable_type
            ]);
        }

        // If checks pass,close any confirmation modal and proceed to the quiz questions page.
        $this->showConfirmationModal = false;

        // Redirect to the quiz questions page with the necessary parameters.
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