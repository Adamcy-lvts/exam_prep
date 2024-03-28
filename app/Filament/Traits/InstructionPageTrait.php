<?php

namespace App\Filament\Traits;

use Exception;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Subject;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait InstructionPageTrait
{
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

    public $user;


    public $duration; // To hold the dynamic duration based on the selected number of questions
    

    /**
     * Mount the component with the provided record and quizzable type.
     * 
     * @param  mixed $record The identifier for the course or subject.
     * @param  string $quizzableType The type of the quizzable ('course' or 'subject').
     * @throws \Exception If an invalid quizzable type is provided.
     */
    public function mount($record, $quizzableType): void
    {

        $this->user = auth()->user();

        try {
            $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $record])->firstOrFail();

            // Retrieve the latest quiz session for the quizzable item.
            $this->existingSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

            // Get the number of allowed attempts, falling back to the default specified in the quizzable model if not already set in the session.
            $this->allowed_attempts = $this->existingSession->allowed_attempts ?? $this->quizzable->max_attempts;

            // Count the number of questions associated with the quizzable.
            $this->numberOfQuestions = $this->quizzable->questions->count();

            if ($this->numberOfQuestions === 0) {
                // Handle the case where no questions are available
                // This could be setting an error message, redirecting the user, etc.
                $this->errorMessage = 'No questions available';
            }

            // Initialize attempts to 0.
            $this->attempts = 0;

            // If there is an existing session, try to find an ongoing attempt that has not yet ended.
            if ($this->existingSession !== null) {
                $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                    ->where('quiz_session_id', $this->existingSession->id)->where('quiz_id', $this->quizzable->id)
                    ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
                    ->first();
                // dd($this->quizzable->quizzable_id);
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
            $attempt = $this->user->courseAttempts()->where('course_id', $this->quizzable->quizzable_id)->first();
            $this->remainingAttempts = $attempt ? ($attempt->attempts_left === null ? 'Unlimited' : $attempt->attempts_left) : 0;

            // Error handling: Check if the user has exceeded the allowed number of attempts.
            if ($this->remainingAttempts < 0) {
                // Log this issue as it shouldn't normally happen, indicating a potential problem in attempts tracking.
                Log::warning('User has exceeded the number of allowed attempts', [
                    'user_id' => auth()->user()->id,
                    'quizzable_id' => $this->quizzable->quizzable_id,
                    'attempts' => $this->attempts,
                    'allowed_attempts' => $this->allowed_attempts
                ]);
                // Optionally, you could throw an exception or handle this case as per your application's requirement.
            }

            // More error handling could be added here to deal with other edge cases, such as:
            // - Invalid or corrupted session data.
            // - Inconsistencies between the session state and the database records.
            // - Handling situations where the quizzable has no questions.
            if ($this->numberOfQuestions === 0) {
                // This is a critical issue as quizzes should have questions.
                Log::error('Quizzable has no questions.', [
                    'quizzable_id' => $this->quizzable->quizzable_id,
                    'quizzable_type' => $quizzableType
                ]);
                // Handle the error according to the needs of your application.
            }
        } catch (ModelNotFoundException $e) {
            // Handle the case where the Quiz was not found
            // lets find the quizzable item in course or subject and use the title of course or subject
            $quizzable = Course::find($record) ?? Subject::find($record);
            // dd($this->quizzable->name ?? $this->quizzable->title);
            Notification::make()
                ->title("No quiz found for " . ($quizzable->name ?? $quizzable->title))
                ->warning()
                ->send();
            $this->redirectRoute('filament.user.resources.courses.index');
        }

        
      
    }


    // Check if user can attempt the quiz
    public function canAttemptQuiz()
    {
        $latestSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

        if (!$latestSession) {
            return true;  // If no session exists, user can attempt
        }

        // Check if the user has an ongoing attempt for the latest session
        $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('quiz_session_id', $latestSession->id)->where('quiz_id', $this->quizzable->quizzable_id)
            ->whereNull('end_time')  // assuming 'end_time' is set when the quiz is submitted.
            ->first();

        if ($this->ongoingAttempt) {
            return true;  // If there's an ongoing attempt, user can continue
        }

        // If no ongoing attempt, check the total number of attempts by the user
        $attempts = QuizAttempt::where('user_id', auth()->user()->id)->where('quiz_id', $this->quizzable->quizzable_id)
            ->where('quiz_session_id', $latestSession->id)
            ->count();

        // Check if the user has exceeded the allowed attempts
        return $attempts < $latestSession->allowed_attempts;
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


    /**
     * Handle the "updated" lifecycle event for the selectedNumberOfQuestions property.
     * This method is automatically invoked by Livewire when selectedNumberOfQuestions changes.
     */
    public function updatedSelectedNumberOfQuestions()
    {
        // Call the updateDuration method to adjust the quiz duration based on the new number of questions selected.
        // This keeps the quiz duration in sync with the number of questions.
        $this->updateDuration();
    }

    /**
     * Update the quiz duration based on a predefined mapping of the number of questions to duration.
     * This method uses a mapping array where the keys are the number of questions and the values are the corresponding durations.
     */
    protected function updateDuration()
    {
        // Define a mapping from the number of questions to the corresponding duration in minutes.
        // These values are based on an estimated time that it should take to complete a set number of questions.
        $durationMapping = [
            20 => 5,   // For 20 questions, the duration is 5 minutes.
            50 => 30,  // For 50 questions, the duration is 30 minutes.
            70 => 45,  // For 70 questions, the duration is 45 minutes.
            100 => 60, // For 100 questions,the duration is 60 minutes.
            150 => 90, // For 150 questions, the duration is 90 minutes.
        ];


        // Check if the selected number of questions is in the mapping.
        if (isset($durationMapping[$this->selectedNumberOfQuestions])) {
            // If a match is found, update the duration accordingly.
            $this->duration = $durationMapping[$this->selectedNumberOfQuestions];
        } else {
            // If no match is found, fall back to the default duration specified in the quizzable model.
            // This ensures there's always a valid duration for the quiz, preventing any unexpected behavior or errors.
            $this->duration = $this->quizzable->duration;
        }

        // Additional error handling can be implemented here to handle cases where the quizzable model may not have a default duration set.
        if ($this->duration === null) {
            // Log this as a critical issue because a quiz without a duration could lead to user experience issues or system errors.
            Log::critical('Quiz duration is not set.', [
                'selected_number_of_questions' => $this->selectedNumberOfQuestions,
                'quizzable_id' => $this->quizzable->id,
            ]);
            // Depending on application requirements, set a default duration or handle this error as needed.
            $this->duration = 60; // Setting a default duration of 60 minutes for example.
        }
    }

    /**
     * Prepares to show a confirmation modal to the user.
     */
    public function askForConfirmation(): void
    {
        // Flag to trigger modal display.
        $this->showConfirmationModal = true;
    }

    /**
     * Fetch the latest quiz session for the current user and quizzable item.
     *
     * @param  mixed $quizzableId The ID of the quizzable item.
     * @param  string $quizzableType The class type of the quizzable item.
     * @return QuizSession|null The latest session or null.
     */
    private function getLatestSession($quizzableId, $quizzableType)
    {
        // Returns the latest quiz session for the user and quizzable item.
        return QuizSession::where('user_id', auth()->user()->id)
            ->where('quizzable_type', $quizzableType)
            ->where('quizzable_id', $quizzableId)
            ->latest()
            ->first();
    }

    public function showStartQuizConfirmation()
    {
        // Any preparatory logic before showing the modal goes here

        // Show the modal
        $this->showConfirmationModal = true;
    }

    private function getPage()
    {
        // Fetching the current page from the request or defaulting to 1 if not specified
        return request()->get('page', 1);
    }
}
