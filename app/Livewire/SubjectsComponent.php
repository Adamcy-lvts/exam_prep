<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Option;

class SubjectsComponent extends Component
{
    use WithPagination;

    public $subject;
    public $currentAttempt;
    public $randomQuestionIds;
    public $attemptQuestionIds;
    public $currentQuestionId;
    public $answers = [];
    public $perPage = 1;

    protected $listeners = ['questionAnswered' => '$refresh'];

    public function mount($subjectId, $attemptId)
    {
        $this->subject = Subject::findOrFail($subjectId);
        $this->currentAttempt = QuizAttempt::findOrFail($attemptId);

        // Fetch 50 random question IDs
        $this->randomQuestionIds = Question::where('quizzable_id', $this->subject->id)
            ->where('quizzable_type', $this->subject->getMorphClass())
            ->inRandomOrder()
            ->take(50)
            ->pluck('id')
            ->toArray();

        // Attach these questions to the current attempt if they haven't been attached yet
        if ($this->currentAttempt->questions()->count() == 0) {
            foreach ($this->randomQuestionIds as $questionId) {
                $this->currentAttempt->questions()->attach($questionId);
            }
        }

        // Fetch question IDs associated with the current attempt
        $this->attemptQuestionIds = $this->currentAttempt->questions()
            ->orderBy('quiz_attempt_questions.id')
            ->pluck('questions.id')
            ->toArray();

        $this->setCurrentQuestionId();
        $this->loadAnswers();
    }

    private function setCurrentQuestionId()
    {
        $this->currentQuestionId = $this->getQuestionsProperty()->first()->id ?? null;
    }

    private function loadAnswers()
    {
        $this->answers = QuizAnswer::where('quiz_attempt_id', $this->currentAttempt->id)
            ->pluck('option_id', 'question_id')
            ->toArray();
    }

    public function setAnswer($questionId, $optionId = null, $answerText = null)
    {
        $question = Question::find($questionId);

        if ($question->type == Question::TYPE_MCQ) {
            $isCorrect = Option::where('id', $optionId)->where('is_correct', 1)->exists();

            $answer = QuizAnswer::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'question_id' => $questionId,
                    'quiz_attempt_id' => $this->currentAttempt->id
                ],
                [
                    'option_id' => $optionId,
                    'completed' => false,
                    'correct' => $isCorrect
                ]
            );

            $this->answers[$questionId] = $optionId;
        } elseif ($question->type == Question::TYPE_SAQ) {
            $sanitizedUserAnswer = $this->sanitizeAnswer($answerText);
            $sanitizedCorrectAnswer = $this->sanitizeAnswer($question->answer_text);

            $answer = QuizAnswer::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'question_id' => $questionId,
                    'quiz_attempt_id' => $this->currentAttempt->id
                ],
                [
                    'answer_text' => $answerText,
                    'completed' => false,
                    'correct' => ($sanitizedUserAnswer == $sanitizedCorrectAnswer)
                ]
            );

            $this->answers[$questionId] = $answerText;
        } elseif ($question->type == Question::TYPE_TF) {
            $answer = QuizAnswer::updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'question_id' => $questionId,
                    'quiz_attempt_id' => $this->currentAttempt->id
                ],
                [
                    'answer_text' => $optionId,
                    'completed' => false,
                    'correct' => ($optionId == $question->correct_answer)
                ]
            );

            $this->answers[$questionId] = $optionId;
        }

        $this->currentQuestionId = $questionId;
        $this->dispatch('questionAnswered');
    }

    public function getQuestionsProperty()
    {
        return $this->currentAttempt->questions()
            ->orderBy('quiz_attempt_questions.id')
            ->simplePaginate($this->perPage);
    }

    public function getAnsweredQuestionsProperty()
    {
        return $this->currentAttempt->answers()->pluck('question_id')->toArray();
    }

    public function goToQuestion($index)
    {
        $this->currentQuestionId = $this->attemptQuestionIds[$index - 1] ?? null;
        $this->setPage($index);
    }

    private function sanitizeAnswer($answer)
    {
        return strtolower(trim($answer));
    }

    public function render()
    {
        return view('livewire.subjects-component', [
            'questions' => $this->questions,
            'answeredQuestions' => $this->answeredQuestions,
            'currentQuestionId' => $this->currentQuestionId,
        ]);
    }
}
