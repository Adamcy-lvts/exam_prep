<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Topic;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use Livewire\Attributes\On;
use App\Models\SubjectTopic;
use Livewire\WithPagination;
use App\Models\TopicQuizAttempt;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TopicQuizComponent extends Component
{

    public $answers = [];
    public $subject;
    public $examId;
    public $exam;
    public $fieldID;
    public $topics;
    public $selectedTopicId = null;
    public $showQuizModal = false;
    public $clickedTopic;
    public $previousTopicName;
    public $showQuizInstructions = true;
    public $previousTopicId;
    public $showConfirmationModal = false;

    public $currentTopicId;
    public $showQuiz = false;

    public $questionIds = [];
    public $currentQuestionIndex = 0;
    public $currentQuestion = null;
    public $currentOptions = [];

    public $currentAttemptId;
    public $topicId;

    public $currentAttempt;

    protected $listeners = ['initiateQuiz'];

    public function mount($topicId = null)
    {
        $this->topicId = $topicId;
        $this->currentAttempt = $this->fetchCurrentQuizAttempt($this->topicId);
    }

    protected function fetchCurrentQuizAttempt($topicId)
    {
        // Fetch the current quiz attempt for the user and topic
        $currentAttempt = TopicQuizAttempt::where('user_id', Auth::id())
            ->where('topic_id', $topicId)
            ->where('completed', false)
            ->latest()
            ->first();

        return $currentAttempt;
    }

    public function initiateQuiz($topicId)
    {
        $this->startQuiz($topicId);
    }

    public function startQuiz($topicId)
    {

        // Check if there is an existing quiz attempt for this topic and user
        $existingAttempt = TopicQuizAttempt::where('user_id', Auth::id())
            ->where('topic_id', $topicId)
            ->where('completed', false)
            ->first();

        // If there is no existing attempt, create a new one
        if (!$existingAttempt) {
            $this->currentAttempt = TopicQuizAttempt::create([
                'user_id' => Auth::id(),
                'topic_id' => $topicId,
                'score' => 0, // initial score
                'passed' => false,
                'completed' => false,
            ]);
        }

        // Set up the quiz questions and state
        $this->questionIds = Question::where('topic_id', $topicId)->pluck('id')->toArray();
        $this->loadCurrentQuestion();
        $this->showQuiz = true;

        // Store quiz state in the session
        session([
            'quizState' => [
                'questionIds' => $this->questionIds,
                'currentQuestionIndex' => $this->currentQuestionIndex,
                'topicId' => $topicId, // Store the topic ID in the session as well
            ]
        ]);

        // Close the modal
        $this->dispatch('close-modal', ['id' => 'quiz-instructions-modal']);
    }

    public function loadCurrentQuestion()
    {
        $currentQuestionId = $this->questionIds[$this->currentQuestionIndex] ?? null;
        $this->currentQuestion = Question::find($currentQuestionId);
        $this->currentOptions = $this->currentQuestion->options()->get() ?? [];

        session(['quizState.currentQuestionIndex' => $this->currentQuestionIndex]);
    }

    public function goToNextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questionIds) - 1) {
            $this->currentQuestionIndex++;
            $this->loadCurrentQuestion();
        }
        session(['quizState.currentQuestionIndex' => $this->currentQuestionIndex]);
    }

    public function goToPreviousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->loadCurrentQuestion();
        }
        session(['quizState.currentQuestionIndex' => $this->currentQuestionIndex]);
    }

    public function resetQuiz()
    {
        // Reset the quiz-related properties
        $this->showQuiz = false;
        $this->questionIds = [];
        $this->currentQuestionIndex = 0;
        $this->currentQuestion = null;
        $this->currentOptions = [];

        // Clear the quiz state from the session
        session()->forget('quizState');
    }


    public function setAnswer($questionId, $optionId = null, $answerText = null)
    {
        // dd($questionId);
        $question = Question::find($questionId);

        if ($question->type == Question::TYPE_MCQ) {
            // Determine if the selected option is correct
            $isCorrect = Option::where('id', $optionId)->where('is_correct', 1)->exists();

            // Find or create the answer
            $answer = QuizAnswer::firstOrCreate([
                'user_id' => auth()->user()->id,
                'question_id' => $questionId,
                'topic_id' => $this->topicId,
                'topic_quiz_attempt_id' => $this->currentAttempt->id
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
                'topic_id' => $this->topicId,
                'topic_quiz_attempt_id' => $this->currentAttempt->id
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
                'topic_id' => $this->topicId,
                'topic_quiz_attempt_id' => $this->currentAttempt->id
            ]);

            $answer->answer_text = $optionId;
            // Store either 'true' or 'false' as the answer text

            $this->answers[$questionId] = $optionId;
            $answer->save();
        }
    }

    public function submitQuiz()
    {
        $score = 0;
        $totalMarks = 0;
        $questions = $this->currentAttempt->topic->questions;

        foreach ($questions as $question) {
            $totalMarks += $question->marks;
            $userAnswer = $this->currentAttempt->quizAnswers->where('question_id', $question->id)->first();

            if ($userAnswer && $userAnswer->correct) {
                $score += $question->marks;
            }
        }

        // Calculate the passing score as 50% of the total marks
        $passingScore = $totalMarks / 2;
        $passed = $score >= $passingScore;

        // Update the current topic quiz attempt with the score and passed status
        $this->currentAttempt->update([
            'score' => $score,
            'passed' => $passed,
            'completed' => true
        ]);

        // If passed, unlock the next topic
        if ($passed) {
            $nextTopic = Topic::where('order', '>', $this->currentAttempt->topic->order)
                ->orderBy('order', 'asc')
                ->first();

            if ($nextTopic) {
                // Logic to unlock the next topic
                // This could be setting a flag in the database, or managing user progress in some way
            }
        }

        if ($passed) {
            // Flash a success message and unlock the next topic
            session()->flash('message', 'Congratulations! You have passed the quiz and the next topic is now unlocked.');
        } else {
            // Flash a failure message and encourage the user to try again
            session()->flash('message', 'Unfortunately, you did not pass. Please review the topic and try the quiz again.');
        }

        // After the quiz is submitted, hide the quiz and show the message
        $this->showQuiz = false;
    }
    public function render()
    {
        return view('livewire.topic-quiz-component');
    }
}
