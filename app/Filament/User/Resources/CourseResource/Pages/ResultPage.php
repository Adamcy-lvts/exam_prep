<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\TopicPerformance;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\CourseResource;
use App\Models\QuizSession;

class ResultPage extends Page
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.result-page';

    public $course;
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


    public function mount($attemptId, $courseId): Void
    {
        $this->course = Course::find($courseId);

        $totalM = $this->course->total_marks;

        $this->totalMarks = $totalM;
        // dd($attemptId);
        $this->testAnswers = QuizAnswer::where('quiz_attempt_id', $attemptId)->where('completed', true)->get(); // Assuming you have a "TestAnswer" model for test answers

        $this->answeredCorrectQuestions = $this->testAnswers->where('correct', 1)->count();

        $wronglyAnsweredMcq = $this->testAnswers->where('correct', 0)->where('option_id', true)->count();

        $wronglyAnsweredSaq = $this->testAnswers->where('correct', 0)->where('answer_text', true)->count();

        $this->answeredWrongQuestions = $wronglyAnsweredMcq + $wronglyAnsweredSaq;

        $this->unansweredQuestions =  $this->testAnswers->where('option_id', null)->where('answer_text', null)->count();

        // dd($unansweredQuestions);

        $this->currentAttempt = QuizAttempt::find($attemptId);

        $this->totalScore = $this->currentAttempt->score;

        $session = QuizSession::find($this->currentAttempt->quiz_session_id);

        $this->attempts = $session->allowed_attempts;

        // Get the questions and options related to the test answers
        $this->questions = Question::whereIn('id', $this->testAnswers->pluck('question_id'))->with('options')->get(); // Assuming you have a "Question" model for questions and a relationship between Question and Option models

        $startTime = Carbon::parse($this->currentAttempt->start_time);
        $endTime = Carbon::parse($this->currentAttempt->end_time);

        if ($startTime && $endTime) {
            $timeSpent = $startTime->diffInSeconds($endTime); // Get the time difference in seconds
            $this->formattedTimeSpent = gmdate('H:i:s', $timeSpent); // Format as HH:MM:SS
        }

        $quizAttemptId = $this->currentAttempt->id; // You would get the current attempt ID from the user's session or the page URL.

        // If no ongoing attempt, check the total number of attempts by the user
        $attempts = QuizAttempt::where('user_id', auth()->user()->id)->where('course_id', $this->course->id)
            ->where('quiz_session_id', $session->id)
            ->count();

        // Check if the user has exceeded the allowed attempts
        $this->remainingAttempts =  $this->attempts - $attempts;

        // Fetch the topic performance data for this attempt
        $topicPerformances = TopicPerformance::with('topic') // Assuming you have a 'topic' relationship on your TopicPerformance model
            ->where('quiz_attempt_id', $quizAttemptId)
            ->get();



        // Define the threshold for doing well
        $performanceThreshold = 70;

        // Organize topics by module and unit
        $organizedPerformances = $this->currentAttempt->topicPerformances
        ->groupBy(function ($performance) {
            return optional($performance->topic->unit)->module->id ?? 'no_module';
        })
        ->map(function ($groupedPerformances) use ($performanceThreshold) {
            return $groupedPerformances
                ->groupBy(function ($performance) {
                    return $performance->topic->unit->id ?? 'no_unit';
                })
                ->map(function ($performances) use ($performanceThreshold) {
                    // Separate the performances into 'did well' and 'did not do well'
                    $didWell = $performances->filter(function ($performance) use ($performanceThreshold) {
                        return $performance->correct_answers_count / $performance->questions_count * 100 >= $performanceThreshold;
                    });
                    $didNotDoWell = $performances->reject(function ($performance) use ($performanceThreshold) {
                        return $performance->correct_answers_count / $performance->questions_count * 100 >= $performanceThreshold;
                    });
                    return compact('didWell', 'didNotDoWell');
                });
        });

        // Now you have a nested collection organized by module and unit
        $this->organizedPerformances = $organizedPerformances;
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->course->course_code . ' ' . $this->course->title);
    }
}
