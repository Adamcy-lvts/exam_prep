<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\WithPagination;

class SubjectsComponent extends Component
{
    use WithPagination;

    public $subject;
    public $answers = [];
    public $currentAttempt;
    public $allQuestions;
    public $page;

    public function mount($subjectId, $attemptId)
    {
        $this->currentAttempt = QuizAttempt::findOrFail($attemptId);
        
        $this->subject = Subject::findOrFail($subjectId);

        $this->allQuestions = $this->subject->questions;
// dd($this->allQuestions);
        $this->loadAnswers();

    }

    public function goToQuestion($pageNumber)
    {
        // dd('Hello');
        $this->setPage($pageNumber);
    }

    private function loadAnswers()
    {
        
        $answers = QuizAnswer::where('quiz_attempt_id', $this->currentAttempt->id)
            ->pluck('option_id', 'question_id');

        $this->answers = $answers->all();
    }


    public function getQuestionsProperty()
    {
        $this->loadAnswers();
        return Question::where('quizzable_id', $this->subject->id)
            ->where('quizzable_type', $this->subject->getMorphClass())
            ->simplePaginate(1);
    }

    public function setAnswer($questionId, $optionId = null, $answerText = null)
    {
        // dd('hello');
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

            $this->answers[$questionId] = $optionId ?? $answerText;
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

            $this->answers[$questionId] = $optionId ?? $answerText;
            $answer->save();
        } elseif ($question->type == Question::TYPE_TF) {
            $answer = QuizAnswer::firstOrNew([
                'user_id' => auth()->user()->id,
                'question_id' => $questionId,
                'quiz_attempt_id' => $this->currentAttempt->id
            ]);

            $answer->answer_text = $optionId;
            // Store either 'true' or 'false' as the answer text

            $this->answers[$questionId] = $optionId;
            $answer->save();
        }
    }

    public function render()
    {
        return view('livewire.subjects-component', [
            'questions' => $this->questions
        ]);
    }
}

 // private function loadAnswers()
    // {
    //     $cacheKey = 'quiz_answers_' . $this->currentAttempt->id;

    //     $this->answers = cache()->remember($cacheKey, now()->addMinutes(30), function () {
    //         return QuizAnswer::where('quiz_attempt_id', $this->currentAttempt->id)
    //             ->pluck('option_id', 'question_id')
    //             ->all();
    //     });
    // }