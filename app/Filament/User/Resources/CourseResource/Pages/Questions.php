<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Course;
use App\Models\Option;
use App\Livewire\Timer;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Livewire\WithPagination;
use App\Models\TopicPerformance;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\CourseResource;

class Questions extends Page
{
    use WithPagination;
    protected static string $resource = CourseResource::class;

    // protected static string $view = 'filament.user.resources.course-resource.pages.questions';

    // public $questions;
    public $course;
    public $answers = [];
    public $totalQuestions;
    public $remainingTime;
    public $currentAttempt;
    public $ongoingAttempt;
    public $existingSession;
    public $allowed_attempts;

    protected $listeners = ['timesUp' => 'submitTest'];

    public function mount($record): void
    {

        $this->course = Course::with('questions')->findOrFail($record); // Use findOrFail to handle the case where the ID doesn't exist
        // Checking for an existing quiz session for the current user & course
        $this->existingSession = $this->getLatestSession($this->course->id);

        $this->allowed_attempts = $this->existingSession->allowed_attempts ?? '';


        // Fetching the course details

        $this->totalQuestions = $this->course->questions->count();

        if (!$this->existingSession) {
            $quizSession = QuizSession::create([
                'user_id' => auth()->user()->id,
                'course_id' => $this->course->id,
                'start_time' => now(),
                'duration' => $this->course->duration,
                'allowed_attempts' => $this->course->max_attempts,
            ]);
        } else if ($this->existingSession->completed) {
            $this->existingSession->update([
                'start_time' => now(),
                'completed' => false,
            ]);
            $quizSession = $this->existingSession;
        } else {
            $quizSession = $this->existingSession;
        }

        // Here, $quizSession is either a newly created session, an updated old session, or just the old session.
        // Now, we check if there's an ongoing attempt for this session:

        $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('quiz_session_id', $quizSession->id)->where('course_id', $this->course->id)
            ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
            ->first();

        if (!$this->ongoingAttempt) {
            // Create a new attempt only if there's no ongoing attempt
            $this->currentAttempt = QuizAttempt::create([
                'user_id' => auth()->user()->id,
                'course_id' => $this->course->id,
                'quiz_session_id' => $quizSession->id,
                'start_time' => now(),
                'score' => 0
            ]);
        } else {
            $this->currentAttempt = $this->ongoingAttempt;
        }

        // Fetch the saved answers for the user
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


        $this->remainingTime = $this->getRemainingTime();
    }

    private function getPage()
    {
        // Fetching the current page from the request or defaulting to 1 if not specified
        return request()->get('page', 1);
    }

    private function getLatestSession()
    {
        return QuizSession::where('user_id', auth()->user()->id)
            ->where('course_id', $this->course->id)
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

        $quizSession = $this->getLatestSession($this->course->id);

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

    public function clearSession()
    {
        session()->forget('selected_answers');
    }

    // Submitting the test and calculating the user's score
    public function submitTest()
    {
        // dd($answerText);
        $score = 0;
        $topicPerformanceData = []; // Use to hold the performance data per topic

        $questions = $this->course->questions;


        foreach ($questions as $question) {
            $userAnswer = QuizAnswer::where('user_id', auth()->user()->id)
                ->where('question_id', $question->id)->where('quiz_attempt_id', $this->currentAttempt->id)
                ->where('completed', false)
                ->first();

            // Initialize or update topic performance data
            if ($question->topic_id) {
                if (!isset($topicPerformanceData[$question->topic_id])) {
                    $topicPerformanceData[$question->topic_id] = [
                        'correct_answers_count' => 0,
                        'questions_count' => 0,
                    ];
                }
                $topicPerformanceData[$question->topic_id]['questions_count']++;
            }

            if ($userAnswer && $userAnswer->correct) {
                $score += $question->marks;

                // Increment the correct answer count for the topic
                if ($question->topic_id) {
                    $topicPerformanceData[$question->topic_id]['correct_answers_count']++;
                }
            } elseif (!$userAnswer) {
                // If the user hasn't answered this question, create a record for it
                QuizAnswer::create([
                    'user_id' => auth()->user()->id,
                    'question_id' => $question->id,
                    'quiz_attempt_id' => $this->currentAttempt->id,
                    'option_id' => null,  // No selected option
                    'correct' => 0,       // Not correct since no answer was provided
                    'completed' => false  // Mark it as not completed
                ]);
            }
        }

        // After submitting the test, save the topic performance data
        foreach ($topicPerformanceData as $topicId => $performanceData) {
            // Here you would save the performance data to the database
            // For example:
            TopicPerformance::create([
                'quiz_attempt_id' => $this->currentAttempt->id,
                'topic_id' => $topicId,
                'correct_answers_count' => $performanceData['correct_answers_count'],
                'questions_count' => $performanceData['questions_count'],
            ]);
        }


        // Update the quiz session
        $quizSession = $this->getLatestSession(); // Use the helper method

        if ($quizSession) {
            $quizSession->update(['completed' => true]);
            $this->currentAttempt->update([
                'end_time' => now(),
                'score' => $score
            ]);
        }
        QuizAnswer::where('user_id', auth()->user()->id)
            ->where('quiz_attempt_id', $this->currentAttempt->id) // Ensure we only target answers from the current session
            ->whereIn('question_id', $questions->pluck('id'))
            ->update(['completed' => true]);


        // Clear session after submission
        $this->clearSession();

        return redirect()->route('filament.user.resources.courses.result', ['attemptId' => $this->currentAttempt->id, 'courseId' => $this->course->id]);
    }

    public function timesUp()
    {
        $this->submitTest();
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->course->course_code . ' ' . $this->course->title);
    }

    public function render(): View
    {
        $questions = $this->course->questions()->paginate(5);
        $allquestions = $this->course->questions()->get();

        // dd($questions);
        return view('filament.user.resources.course-resource.pages.questions', [
            'questions' => $questions,
            'allquestions' => $allquestions,
        ])->layout(static::$layout, [
            'livewire' => $this,
            'maxContentWidth' => $this->getMaxContentWidth(),
            ...$this->getLayoutData(),
        ]);
    }
}
