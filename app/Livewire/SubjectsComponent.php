<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\WithPagination;
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
    public $questionIds;


    public function mount($subjectId, $attemptId)
    {
        // $this->reset();
        $this->currentAttempt = QuizAttempt::findOrFail($attemptId);

        $this->subject = Subject::findOrFail($subjectId);

        if ($this->subject->questions->count() > 50) {
            $this->totalQuestions =  $this->subject->questions->take(50);
        } else {
            $this->totalQuestions =  $this->subject->questions;
        }

        // Fetch 50 random question IDs
        $this->questionIds = Question::where('quizzable_id', $this->subject->id)
            ->where('quizzable_type', $this->subject->getMorphClass())
            ->inRandomOrder()
            ->take(50)
            ->pluck('id')
            ->toArray();

        $this->loadAnswers();

        // Retrieve the questionId from the session
        $questionId = session('lastQuestionId');

        if ($questionId) {
            // Find the page number for the given questionId
            $questionNumber = $this->allQuestions->pluck('id')->search($questionId) + 1;

            // If the question number is valid, navigate to the corresponding page
            if ($questionNumber !== false) {
                $this->goToQuestion($questionNumber);
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

    // public function getQuestionsProperty()
    // {
    //     $this->loadAnswers();

    //     // Convert collection to query builder instance
    //     $questions = Question::query()
    //         ->where('quizzable_id', $this->subject->id)
    //         ->where('quizzable_type', $this->subject->getMorphClass())
    //         ->inRandomOrder();

    //         dd($questions);

    //     // Paginate the results
    //     $paginatedQuestions = $questions->simplePaginate(1); // Change the number to your desired items per page

    //     return $paginatedQuestions;
    // }

    public function getQuestionsProperty()
    {
        $this->loadAnswers();

        // // Fetch 50 random questions
        // $questions = Question::where('quizzable_id',
        //     $this->subject->id
        // )->where('quizzable_type', $this->subject->getMorphClass())
        // ->inRandomOrder()
        // ->take(50)
        // ->get();
        // Fetch questions using the stored IDs
        $questions = Question::whereIn('id', $this->questionIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $this->questionIds) . ')')
            ->get();


        // Get current page from request, default is 1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Create a new LengthAwarePaginator instance
        $paginatedQuestions = new LengthAwarePaginator(
            $questions->forPage($currentPage, 1), // Items for current page
            $questions->count(), // Total items
            1, // Items per page
            $currentPage, // Current page
            ['path' => LengthAwarePaginator::resolveCurrentPath()] // Page path
        );

        return $paginatedQuestions;
    }


    public function previousPage()
    {
        $this->setPage($this->questions->currentPage() - 1);
    }

    public function nextPage()
    {
        $this->setPage($this->questions->currentPage() + 1);
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
