<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use App\Models\TopicPerformance;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\Traits\ResultPageTrait;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\CourseResource;

class ResultPage extends Page
{
    // use ResultPageTrait;

    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.result-page';

    public $quizzable;
    public $totalMarks;
    public $answeredCorrectQuestions;
    public $answeredWrongQuestions;
    public $unansweredQuestions;
    public $totalScore;
    public $formattedTimeSpent;
    public $questions;
    public $testAnswers;
    public $currentAttempt;
    public $topicsDidWell;
    public $topicsDidNotDoWell;
    public $organizedPerformances;
    public $attempts;
    public $remainingAttempts;
    public $quizzableType;
    public $user;

    public $numberOfQuestions;

    public function mount($attemptId, $quizzableId, $quizzableType): Void
    {
        $this->user = Auth::user();

        $this->quizzable = Quiz::with('questions')->where(['quizzable_type' => $quizzableType, 'quizzable_id' => $quizzableId])->firstOrFail();


        $this->testAnswers = QuizAnswer::where('quiz_attempt_id', $attemptId)->where('completed', true)->get(); // Assuming you have a "TestAnswer" model for test answers
        // dd($this->testAnswers); 
        $this->answeredCorrectQuestions = $this->testAnswers->where('correct', 1)->count();

        $wronglyAnsweredMcq = $this->testAnswers->where('correct', 0)->where('option_id', true)->count();

        $wronglyAnsweredSaq = $this->testAnswers->where('correct', 0)->where('answer_text', true)->count();

        $this->answeredWrongQuestions = $wronglyAnsweredMcq + $wronglyAnsweredSaq;

        $this->unansweredQuestions =  $this->testAnswers->where('option_id', null)->where('answer_text', null)->count();

        // dd($unansweredQuestions);

        $this->currentAttempt = QuizAttempt::find($attemptId);



        $this->totalScore = $this->currentAttempt->score;
        // dd($this->totalScore);
        $session = QuizSession::find($this->currentAttempt->quiz_session_id);

        // $this->attempts = $session->allowed_attempts;

        // Get the questions and options related to the test answers
        $this->questions = Question::whereIn('id', $this->testAnswers->pluck('question_id'))->with('options')->get(); // Assuming you have a "Question" model for questions and a relationship between Question and Option models

        // dd($this->questions->sum('marks'));

        // and sum their marks to get the total.
        $this->totalMarks = $this->questions->sum('marks');

        $this->numberOfQuestions = $this->questions->count();


        if ($session) {
            $startTime = Carbon::parse($this->currentAttempt->start_time);
            $now = Carbon::now();

            // Retrieve the duration from the quiz session
            $totalAllottedTime = $session->duration * 60; // Convert to milliseconds

            // Calculate elapsed time based on the current time and start time.
            $elapsedTime = $startTime->diffInSeconds($now);

            // Limit the elapsed time to the total allotted time.
            $timeSpent = min($elapsedTime, $totalAllottedTime);

            // Format the time spent as HH:MM:SS
            $this->formattedTimeSpent = gmdate('H:i:s', $timeSpent);
        } else {
            // Handle the case where the quiz session is not found
            $this->formattedTimeSpent = '00:00:00';
        }

        $quizAttemptId = $this->currentAttempt->id; // You would get the current attempt ID from the user's session or the page URL.

        // // If no ongoing attempt, check the total number of attempts by the user
        // $attempts = QuizAttempt::where('user_id', auth()->user()->id)->where('quiz_id', $this->quizzable->id)
        //     ->where('quiz_session_id', $session->id)
        //     ->count();


        // Conditional checking for attempts based on quizzable type
        if ($this->quizzableType === 'App\Models\Subject') {
            $attempt = $this->user->subjectAttempts()->where('subject_id', $this->quizzable->quizzable_id)->first();
            $this->remainingAttempts = $attempt ? ($attempt->attempts_left === null ? 'Unlimited' : $attempt->attempts_left) : 0;
        } elseif ($this->quizzableType === 'App\Models\Course') {
            $attempt = $this->user->courseAttempts()->where('course_id', $this->quizzable->quizzable_id)->first();
            $this->remainingAttempts = $attempt ? ($attempt->attempts_left === null ? 'Unlimited' : $attempt->attempts_left) : 0;
        } else {
            // Handle other quizzable types or default case
            $this->remainingAttempts = 0;
        }

        // Fetch the topic performance data for this attempt
        $topicPerformances = TopicPerformance::with('topic') // Assuming you have a 'topic' relationship on your TopicPerformance model
            ->where('quiz_attempt_id', $quizAttemptId)
            ->get();


        // my original logic
        // Define the threshold for doing well
        $performanceThreshold = 70;



        // your logic
        // Start by grouping performances at the highest level available - module, unit, or directly by topic
        $organizedPerformances = $this->currentAttempt->topicPerformances->groupBy(function ($performance) {
            if ($performance->topic->unit && $performance->topic->unit->module) {
                return $performance->topic->unit->module->id;
            }
            return 'directly_associated'; // Topics directly associated with the course/subject
        })->map(function ($groupedPerformances) use ($performanceThreshold) {
            return $groupedPerformances->groupBy(function ($performance) {
                return $performance->topic->unit_id ? $performance->topic->unit_id : 'directly_associated';
            })->map(function ($performances) use ($performanceThreshold) {
                // Separate the performances into 'did well' and 'did not do well'
                $didWell = $performances->filter(function ($performance) use ($performanceThreshold) {
                    return $performance->correct_answers_count / $performance->questions_count * 100 >= $performanceThreshold;
                });
                $didNotDoWell = $performances->filter(function ($performance) use ($performanceThreshold) {
                    return $performance->correct_answers_count / $performance->questions_count * 100 < $performanceThreshold;
                });
                return compact('didWell', 'didNotDoWell');
            });
        });
        $this->organizedPerformances = $organizedPerformances;
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->quizzable->title);
    }
}
