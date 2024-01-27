<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Question;
use App\Models\QuizAnswer;
use Livewire\WithPagination;
use App\Models\TopicPerformance;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use App\Filament\Traits\QuizPageTrait;
use App\Filament\User\Resources\CourseResource;


class Questions extends Page
{

    use QuizPageTrait;
    
    protected static string $resource = CourseResource::class;

    protected $listeners = ['timesUp' => 'submitTest'];
    // protected static string $view = 'filament.user.resources.course-resource.pages.questions';

    // public $questions;

    public function submitTest()
    {
        $score = 0;
        $topicPerformanceData = [];

        // Retrieve the questions associated with the current attempt
        $questionIds = $this->currentAttempt->questions()->pluck('question_id');
        $questions = Question::whereIn('id', $questionIds)->get();


        foreach ($questions as $question) {
            $userAnswer = QuizAnswer::where('user_id', auth()->user()->id)
                ->where('question_id', $question->id)
                ->where('quiz_attempt_id', $this->currentAttempt->id)
                ->where('completed', false)
                ->first();

            if ($userAnswer) {

                // This block should be executed whether or not there's a topic_id
                if ($userAnswer->correct) {
                    $score += $question->marks; // Always increment score if the answer is correct
                }

                // The rest of the topic-related logic remains the same
                if ($question->topic_id) {

                    if (!isset($topicPerformanceData[$question->topic_id])) {
                        $topicPerformanceData[$question->topic_id] = [
                            'correct_answers_count' => 0,
                            'questions_count' => 0,
                        ];
                    }

                    $topicPerformanceData[$question->topic_id]['questions_count']++;

                    if ($userAnswer->correct) {
                        $topicPerformanceData[$question->topic_id]['correct_answers_count']++;
                    }

                    $userAnswer->topic_id = $question->topic_id;
                    $userAnswer->save();
                }
            } elseif (!$userAnswer) {


                $unansweredRecord = QuizAnswer::create([
                    'user_id' => auth()->user()->id,
                    'question_id' => $question->id,
                    'topic_id' => $question->topic_id,
                    'quiz_attempt_id' => $this->currentAttempt->id,
                    'option_id' => null,
                    'correct' => 0,
                    'completed' => false
                ]);
            }
        }





        // Save the topic performance data
        foreach ($topicPerformanceData as $topicId => $performanceData) {
            TopicPerformance::create([
                'quiz_attempt_id' => $this->currentAttempt->id,
                'topic_id' => $topicId,
                'correct_answers_count' => $performanceData['correct_answers_count'],
                'questions_count' => $performanceData['questions_count'],
            ]);
        }

        //  Update the quiz session
        $quizSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type); // Use the helper method

        if ($quizSession) {
            $quizSession->update(['completed' => true]);
            $this->currentAttempt->update([
                'end_time' => now(),
                'score' => $score
            ]);
        }

        // Once the quiz is submitted, delete the associated questions from quiz_attempt_questions table
        $this->currentAttempt->questions()->detach();

        QuizAnswer::where('user_id', auth()->user()->id)
            ->where('quiz_attempt_id', $this->currentAttempt->id) // Ensure we only target answers from the current session
            ->whereIn('question_id', $questions->pluck('id'))
            ->update(['completed' => true]);


        // Clear session after submission
        session()->forget(['selectedNumberOfQuestions', 'selectedDuration']);

        return redirect()->route('filament.user.resources.courses.result', ['attemptId' => $this->currentAttempt->id, 'quizzableId' => $this->quizzable->quizzable_id, 'quizzableType' => $this->quizzable->quizzable_type]);
    }

    public function render(): View
    {
        // $questions = $this->course->questions()->paginate(5);
        // Retrieve question IDs associated with the attempt
        $questionIds = $this->currentAttempt->questions()->pluck('question_id');

        // dd($this->currentAttempt->questions()->pluck('question_id'));
        // Retrieve paginated questions using the IDs from the attempt
        $questions = Question::whereIn('id', $questionIds)->paginate(5);
        $allquestions = Question::whereIn('id', $questionIds)->get();

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
