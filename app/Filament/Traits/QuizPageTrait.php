<?php

namespace App\Filament\Traits;

use App\Models\Quiz;
use App\Models\Course;
use App\Models\Option;
use App\Livewire\Timer;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Livewire\WithPagination;
use App\Models\TopicPerformance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\ModelNotFoundException;


trait QuizPageTrait
{
    use WithPagination;

    public $course;
    public $answers = [];
    public $totalQuestions;
    public $remainingTime;
    public $currentAttempt;
    public $ongoingAttempt;
    public $existingSession;
    public $allowed_attempts;
    public $quizSession;
    public $remainingAttempts;
    public $quizzable;
    public $quizzableType;
    public $user;

    public $selectedNumberOfQuestions;
    public $duration;



    public function mount($record, $quizzableType): void
    {

        $this->user = auth()->user();

        try {

         
            $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'id' => $record])->firstOrFail();

            $this->quizzableType = $this->quizzable->quizzable_type;

            // Now use $quizzableType to instantiate the correct model

            $this->existingSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzableType);
            // dd($this->existingSession);
            $this->allowed_attempts = $this->existingSession->allowed_attempts ?? '';

            // Fetching the course details

            $this->duration = session('selectedDuration', $this->quizzable->duration); // Use course duration as default

            // Start a database transaction
            DB::beginTransaction();

            try {
                $this->existingSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

                if (!$this->existingSession) {
                    $this->quizSession = QuizSession::create([
                        'user_id' => auth()->user()->id,
                        'quizzable_id' => $this->quizzable->quizzable_id,
                        'quizzable_type' => $this->quizzable->quizzable_type,
                        'start_time' => now(),
                        'duration' => $this->duration,
                        'allowed_attempts' => $this->quizzable->max_attempts,
                    ]);
                } else if ($this->existingSession->completed) {
                    $this->existingSession->update([
                        'duration' => $this->duration,
                        'start_time' => now(),
                        'completed' => false,
                    ]);
                    $this->quizSession = $this->existingSession;
                } else {
                    $this->quizSession = $this->existingSession;
                }
                // Commit the transaction
                DB::commit();
            } catch (\Exception $e) {
                // Rollback the transaction
                DB::rollBack();
                throw $e;
            }



            // Here, $quizSession is either a newly created session, an updated old session, or just the old session.
            // Now, we check if there's an ongoing attempt for this session:

            $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('quiz_session_id', $this->quizSession->id)->where('quiz_id', $this->quizzable->id)
            ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
            ->first();

            $latestSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

            // Conditional checking for attempts based on quizzable type
            if ($this->quizzableType === 'App\Models\Subject') {
                $attempt = $this->user->subjectAttempts()->where('subject_id', $this->quizzable->quizzable_id)->first();
                // dd($attempt);
                // Check if attempts_left is null for unlimited attempts
                $this->remainingAttempts = $attempt->attempts_left == null ? 'Unlimited' : $attempt->attempts_left;
            } elseif ($this->quizzableType === 'App\Models\Course') {
                $attempt = $this->user->courseAttempts()->where('course_id', $this->quizzable->quizzable_id)->first();
                // Check if attempts_left is null for unlimited attempts
                $this->remainingAttempts = $attempt->attempts_left == null ? 'Unlimited' : $attempt->attempts_left;
            } else {
                // Handle other quizzable types or default case
                $this->remainingAttempts = 0; // Consider how to handle unlimited cases here too
            }


            // Check for session values and use them if available
            $this->selectedNumberOfQuestions = session('selectedNumberOfQuestions', 100); // Default to 100 if not set in session



            // dd($this->duration);
            $this->totalQuestions = $this->quizzable->questions->count();

            // / Determine the number of questions for the quiz
            // This number can be set dynamically or passed as a parameter
            // For example, it can be a user preference or a setting in the course
            // $this->selectedNumberOfQuestions = $numberOfQuestions; // Default value or retrieve from user preference or course setting
            // dd($this->quizzable->questions->count());
            if (!$this->ongoingAttempt && ($this->remainingAttempts > 0 || $this->remainingAttempts === 'Unlimited')) {
                // Create a new attempt only if there's no ongoing attempt
                $this->currentAttempt = QuizAttempt::create([
                    'user_id' => auth()->user()->id,
                    'quiz_id' => $this->quizzable->id,
                    'quiz_session_id' => $this->quizSession->id,
                    'start_time' => now(),
                    'score' => 0
                ]);
               
                // Retrieve either a random set of questions or all, based on the course's question count
                if ($this->quizzable->questions->count() > $this->selectedNumberOfQuestions) {
                    $randomQuestions = $this->quizzable->questions()
                        ->inRandomOrder()
                        ->limit($this->selectedNumberOfQuestions)
                        ->get();
                } else {
                    // If there are fewer questions than the limit, select all
                    $randomQuestions = $this->quizzable->questions;
                }

                // Attach the selected questions to the current attempt
                foreach ($randomQuestions as $question) {
                    $this->currentAttempt->questions()->attach($question->id);
                }
            } else {
                $this->currentAttempt = $this->ongoingAttempt;
             
            }

            // Fetch the saved answers for the user
            if ($this->currentAttempt) {
                $savedAnswers = QuizAnswer::where('user_id', auth()->user()->id)
                    ->where('quiz_attempt_id', $this->currentAttempt->id)
                    ->get();

                foreach ($savedAnswers as $answer) {
                    if ($answer->question->type == Question::TYPE_MCQ) {
                        $this->answers[$answer->question_id] = $answer->option_id;
                    } elseif ($answer->question->type == Question::TYPE_SAQ) {
                        $this->answers[$answer->question_id]['answer_text'] = $answer->answer_text;
                    } elseif ($answer->question->type == Question::TYPE_TF) {
                        // OR if TF questions are handled like SAQs:
                        $this->answers[$answer->question_id]['answer_text'] = $answer->answer_text;
                    }
                }
            }



            $this->remainingTime = $this->getRemainingTime();
            
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

    private function getPage()
    {
        // Fetching the current page from the request or defaulting to 1 if not specified
        return request()->get('page', 1);
    }

    private function getLatestSession($quizzableId, $quizzableType)
    {
        return QuizSession::where('user_id', auth()->user()->id)
            ->where('quizzable_id', $quizzableId)
            ->where('quizzable_type', $quizzableType)
            ->latest()
            ->first();
    }

    public function setAnswer($questionId, $optionId = null, $answerText = null)
    {
        $question = Question::find($questionId);

        if ($question->type == Question::TYPE_MCQ) {
            // Determine if the selected option is correct
            $isCorrect = Option::where('id', $optionId)->where('is_correct', 1)->exists();

            // Find or create the answer
            $answer = QuizAnswer::firstOrNew([
                'user_id' => auth()->user()->id,
                'question_id' => $questionId,
                'quiz_attempt_id' => $this->currentAttempt->id
            ]);

            // Set the attributes
            $answer->option_id = $optionId;
            $answer->completed = false; // 'completed' => false indicates an ongoing quiz
            $answer->correct = $isCorrect;

            // Save the answer
            $answer->save();
        } elseif ($question->type == Question::TYPE_SAQ) {
            $answer = QuizAnswer::firstOrCreate([
                'user_id' => auth()->user()->id,
                'question_id' => $questionId,
                'quiz_attempt_id' => $this->currentAttempt->id
            ]);

            $answer->answer_text = $answerText;

            // Sanitizing and checking correctness for SAQ in a case-insensitive manner
            $sanitizedUserAnswer = sanitizeAnswer($answerText);
            $sanitizedCorrectAnswer = sanitizeAnswer($question->answer_text);

            // Checking correctness for SAQ
            if ($sanitizedUserAnswer == $sanitizedCorrectAnswer) {
                $answer->correct = true;
            } else {
                $answer->correct = false;
            }


            $answer->save();
        } elseif ($question->type == Question::TYPE_TF) {
            $answer = QuizAnswer::firstOrCreate([
                'user_id' => auth()->user()->id,
                'question_id' => $questionId,
                'quiz_attempt_id' => $this->currentAttempt->id
            ]);

            $answer->answer_text = $optionId;
            // Store either 'true' or 'false' as the answer text

            if (strtolower($optionId) === strtolower($question->answer_text)) {
                $answer->correct = true;
            } else {
                $answer->correct = false;
            }

            $answer->save();
        }
    }

    public function getRemainingTime()
    {

        $quizSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

        if ($quizSession) {
            $startTime = $quizSession->start_time;
            $duration = $quizSession->duration * 60 * 1000;  // Convert duration to milliseconds
            $elapsedTime = now()->diffInSeconds($startTime) * 1000;  // Convert to milliseconds

            $remainingTime = max(0, $duration - $elapsedTime);

            // $this->dispatch('timerUpdated', $remainingTime)->to(Timer::class);
            return $remainingTime;
        }

        return 0;  // Quiz session not found
    }


    public function timesUp()
    {
        $this->submitTest();
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->quizzable->course_code . ' ' . $this->quizzable->title);
    }
}
