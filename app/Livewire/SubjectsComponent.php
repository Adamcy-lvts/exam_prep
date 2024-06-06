<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\WithPagination;
use App\Models\QuizAttemptQuestion;
use Illuminate\Pagination\LengthAwarePaginator;

class SubjectsComponent extends Component
{
    use WithPagination;

    public $subject;
    public $answers = [];
    public $currentAttempt;
    // public $questions;
    public $currentPage = 1;
    public $perPage = 1;
    public $totalQuestions;
    public $subjectId;
    public $questionIds;
    public $allQuestions;


    public function mount($subjectId, $attemptId)
    {
        // $this->reset();

        $this->subjectId = $subjectId;
        $this->currentAttempt = QuizAttempt::findOrFail($attemptId);

        $this->subject = Subject::findOrFail($subjectId);

        // Fetch 50 random question IDs based on the quizzable details
        $this->questionIds = Question::where('quizzable_id', $this->subject->id)
        ->where('quizzable_type', $this->subject->getMorphClass())
        ->inRandomOrder()
        ->take(50)
        ->pluck('id')
        ->toArray();

        // Use the IDs to fetch the actual Question models
        $this->totalQuestions = Question::whereIn('id', $this->questionIds)->get();

        // Attach these questions to the current attempt if they haven't been attached yet
        if ($this->currentAttempt->questions()->count() == 0) {
            foreach ($this->questionIds as $questionId) {
                $this->currentAttempt->questions()->attach($questionId);
            }
        }

        $this->loadAnswers();
        // Fetching questions directly associated with the attempt
        $this->allQuestions = $this->currentAttempt->questions()->pluck('questions.id');

        // Handling redirection to the last answered question
        $questionId = session('lastQuestionId');
        // dd($questionId);
        if ($questionId) {
            $questionIndex = $this->allQuestions->search($questionId);
            // dd($questionIndex);
            logger($questionIndex);
            if ($questionIndex !== false) {
                $this->goToQuestion($questionIndex + 1); // Adjust for zero-based index
            }
        }
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

        // Since questions are already associated with the attempt, retrieve them directly
        $questions = $this->currentAttempt->questions()
            ->simplePaginate(1);  // Adjust pagination as needed

        return $questions;
    }

    public function setAnswer($questionId, $optionId = null, $answerText = null)
    {
        // Update the session with the last answered question
        session()->forget(['lastQuestionId']);
        session(['lastQuestionId' => $questionId]);
        // $retrievedQuestionId = session('lastQuestionId');
        // dd($retrievedQuestionId);

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
