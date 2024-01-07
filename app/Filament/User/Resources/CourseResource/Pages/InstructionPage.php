<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Course;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use App\Filament\User\Resources\CourseResource;

class InstructionPage extends Page
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.instruction-page';

    public $course;
    public $courseId;
    public $ongoingAttempt;
    public $existingSession;
    public $allowed_attempts;
    public $numberOfQuestions;
    public $showConfirmationModal;
    public $remainingAttempts;
    public $attempts;

    public $selectedNumberOfQuestions = 100;
    public $duration; // To hold the dynamic duration based on the selected number of questions

    public function mount($record): void
    {
        $this->courseId = $record;

        $this->course = Course::with('questions')->findOrFail($this->courseId); // Use findOrFail to handle the case where the ID doesn't exist

        $this->existingSession = $this->getLatestSession($this->course->id);

        $this->allowed_attempts = $this->existingSession->allowed_attempts ?? $this->course->max_attempts;

        $this->numberOfQuestions = $this->course->questions->count();

        $this->attempts = 0;

        if ($this->existingSession !== null) {
            $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_session_id', $this->existingSession->id)->where('course_id', $this->course->id)
                ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
                ->first();
        }

        if ($this->ongoingAttempt) {
            $this->selectedNumberOfQuestions = session('selectedNumberOfQuestions', 100); // Default to 100 if not set in session
            $this->duration = session('selectedDuration', $this->course->duration); // Use course duration as default
        }

        if ($this->existingSession) {
            $this->attempts = QuizAttempt::where('user_id', auth()->user()->id)->where('course_id', $this->course->id)
                ->where('quiz_session_id', $this->existingSession->id)
                ->count();
        }
        $this->updateDuration();
        // Check if the user has exceeded the allowed attempts
        $this->remainingAttempts =  $this->allowed_attempts - $this->attempts;
    }

    public function updatedSelectedNumberOfQuestions()
    {
        // Update the duration when the selected number of questions changes
        $this->updateDuration();
    }

    protected function updateDuration()
    {
        // Mapping of number of questions to duration in minutes
        $durationMapping = [
            20 => 5,
            50 => 30,
            70 => 45,
            100 => 60,
            150 => 90,
        ];

        // Update the duration based on the selected number of questions
        $this->duration = $durationMapping[$this->selectedNumberOfQuestions] ?? $this->course->duration; // Fallback to the course default duration
    }

    private function getLatestSession()
    {
        return QuizSession::where('user_id', auth()->user()->id)
            ->where('course_id', $this->course->id)
            ->latest()
            ->first();
    }

    public function askForConfirmation(): void
    {
        // dd('Hello');
        $this->showConfirmationModal = true;
    }

    public function startQuiz()
    {

        // Store the selected number of questions and duration in the session
        session([
            'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
            'selectedDuration' => $this->duration,
        ]);

        if (!$this->canAttemptQuiz()) {

            session()->flash('success_message', "You have exhausted your maximum of " . $this->allowed_attempts . " attempts for this quiz.");
            Notification::make()->title(
                "You have exhausted your maximum of " . $this->allowed_attempts . " attempts for this quiz."
            )->warning()->send();

            return redirect()->route('filament.user.resources.courses.instruction-page', $this->course->id);
        }

        $canStart = $this->canStartQuiz();

        // Check the status returned by the canStartQuiz method
        if (!$canStart['status']) {
            $canStart['message'];
            return redirect()->route('dashboard');  // Redirect to the desired route after setting the error message.
        }
        // Initializing selected answers from session or default to an empty array
        // For example, you might redirect them to the quiz page or load the first question.
        // Close the confirmation modal after starting the quiz
        $this->showConfirmationModal = false;

        // Redirect to the specific question route
        return redirect()->route('filament.user.resources.courses.questions', [
            'record' => $this->courseId,
            // 'numberOfQuestions' => $this->selectedNumberOfQuestions // Pass the selected number to the question component
        ]);
    }

    public function continueLastAttempt()
    {


        // Redirecting the user based on the last answered question
        if (auth()->check()) {
            // Determine the total number of questions for the quiz
            $totalQuestions = Course::where('id', $this->courseId)->withCount('questions')->first()->questions_count;

            // Assuming 5 questions per page
            $questionsPerPage = 5;
            $maxPageNumber = ceil($totalQuestions / $questionsPerPage);

            // Check if there's an ongoing attempt for the current user
            $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('course_id', $this->courseId)
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
                        return redirect()->route('filament.user.resources.courses.questions', ['record' => $this->courseId, 'page' => $pageNumber]);
                    }
                }
            } else {
                // If there's no ongoing attempt, always redirect to the first page
                if ($this->getPage() != 1) {
                    return redirect()->route('filament.user.resources.courses.questions', ['record' => $this->courseId, 'page' => 1]);
                }
            }
        }
        return redirect()->route('filament.user.resources.courses.questions', ['record' => $this->courseId]);
    }

    private function getPage()
    {
        // Fetching the current page from the request or defaulting to 1 if not specified
        return request()->get('page', 1);
    }

    public function showStartQuizConfirmation()
    {
        // Any preparatory logic before showing the modal goes here

        // Show the modal
        $this->showConfirmationModal = true;
    }

    public function canStartQuiz()
    {
        if (!$this->canAttemptQuiz()) {
            return [
                'status' => false,
                // 'message' => Notification::make()->title('You have exhausted your maximum of ' . $this->subject->max_attempts . ' attempts for this quiz.')->warning()->send()
            ];
        }

        return [
            'status' => true,  // User can start or continue the quiz.
            'message' => ''
        ];
    }

    // Check if user can attempt the quiz
    public function canAttemptQuiz()
    {
        $latestSession = $this->getLatestSession($this->course->id);

        if (!$latestSession) {
            return true;  // If no session exists, user can attempt
        }

        // Check if the user has an ongoing attempt for the latest session
        $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('quiz_session_id', $latestSession->id)->where('course_id', $this->course->id)
            ->whereNull('end_time')  // assuming 'end_time' is set when the quiz is submitted.
            ->first();

        if ($this->ongoingAttempt) {
            return true;  // If there's an ongoing attempt, user can continue
        }

        // If no ongoing attempt, check the total number of attempts by the user
        $attempts = QuizAttempt::where('user_id', auth()->user()->id)->where('course_id', $this->course->id)
            ->where('quiz_session_id', $latestSession->id)
            ->count();

        // Check if the user has exceeded the allowed attempts
        return $attempts < $latestSession->allowed_attempts;
    }
}
