<?php

namespace App\Livewire;

use App\Models\Topic;
use App\Models\Option;
use Livewire\Component;
use App\Models\Question;
use App\Models\QuizAnswer;
use Livewire\WithPagination;
use App\Models\TopicQuizAttempt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\TopicQuizTimeTracking;
use Livewire\Attributes\On;

class TopicQuiz extends Component
{
    use WithPagination;

    public $answers = [];
    public $questionIds = [];
    public $currentQuestionIndex = 0;
    public $currentQuestion = null;
    public $currentOptions = [];
    public $remainingTime;
    public $remainingTimeInSeconds;

    public $clickedTopic;
    public $previousTopicName;
    public $showQuizInstructions = true;
    public $previousTopicId;
    public $showConfirmationModal = false;

    public $currentTopicId;
    public $showQuiz = false;


    public $currentAttemptId;
    public $topicId;
    public $topic;

    public $currentAttempt;

    public $userTopics;
    public $unlockedTopics;

    public $timeLeftForCurrentQuestion;

    public function mount($topic)
    {
        $this->topic = $topic;
// dd($topic);
        $this->topicId = $topic->id;
        // Attempt to fetch the latest quiz attempt for the current user
        $this->currentAttempt = $this->fetchLatestQuizAttempt();
// dd($this->currentAttempt);
        // dd($this->currentAttempt->topic_id);
        if ($this->currentAttempt && !$this->currentAttempt->completed) {
            $this->currentTopicId = $this->currentAttempt->topic_id;
            $this->showQuiz = true;
            $this->loadQuizStateFromAttempt();
            // $this->currentQuestionIndex = session()->get("currentQuestionIndex_{$this->currentAttempt->topic_id}", 0);
        } else {
            $this->showQuiz = false;
            $this->currentTopicId = null;
        }
    }


    protected function fetchLatestQuizAttempt()
    {
        // Fetch the latest quiz attempt for the current user that is not completed
        return TopicQuizAttempt::where('user_id', Auth::id())
            ->where('completed', false)
            ->latest()
            ->first();
    }

    public function loadQuizStateFromAttempt()
    {
        if (!$this->currentAttempt) {
            return;
        }

        // Assuming 'Topic' has a relationship 'questions' defined
        $topic = Topic::find($this->currentAttempt->topic_id);
        if (!$topic) {
            return;
        }

        $this->topicId = $topic->id;
        // Load questions based on the topic
        $this->questionIds = $topic->questions()->pluck('id')->toArray();
        $this->currentQuestionIndex = 0; // Initialize to the first question or retrieve the saved state if you have one

        // If you're tracking the current question index on the attempt, you can retrieve it like this:
        // $this->currentQuestionIndex = $this->currentAttempt->current_question_index;

        $this->loadCurrentQuestion();

        // Load answers for the current attempt
        $this->answers = QuizAnswer::where('topic_quiz_attempt_id', $this->currentAttempt->id)
            ->pluck('option_id', 'question_id')
            ->toArray();

        $this->showQuiz = true;
    }

    #[On('startQuiz')]
    public function startQuiz($topicId)
    {
        // dd($topicId);
        // session()->forget("currentQuestionIndex_{$this->topicId}"); // Clear the session value
        $this->currentTopicId = $topicId;
        $this->showQuiz = true;

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
                'start_time' => now(),
                'completed' => false,
            ]);
        }
// dd($this->currentAttempt);
        // Set up the quiz questions and state
        $this->questionIds = Question::where('topic_id', $topicId)->pluck('id')->toArray();

        if (!empty($this->questionIds)) {
            $this->loadCurrentQuestion();
        } else {
            session()->flash('error', 'Unfortunately, there are no questions for this topic yet, Please check back soon.');
        }

        // $this->remainingTime = $this->getRemainingTime();

        $this->dispatch('start-timer', remainingTime: $this->getRemainingTime());

        $this->dispatch('close-modal', id: 'quiz-instructions-modal');
    }


    public function getRemainingTime()
    {
        // Assuming you've already loaded $this->currentAttempt and $this->currentQuestion
        if ($this->currentQuestion) {
            $questionStartTimeEntry = TopicQuizTimeTracking::where('topic_quiz_attempt_id', $this->currentAttempt->id)
                ->where('question_id', $this->currentQuestion->id)
                ->first();

            if ($questionStartTimeEntry) {

                $startTime = $questionStartTimeEntry->question_start_time; // Use the specific question start time

                $duration = $this->currentQuestion->duration * 60 * 1000; // Convert duration to milliseconds

                $elapsedTime = now()->diffInSeconds($startTime) * 1000;

                $remainingTime = max(0, $duration - $elapsedTime);
                // dd($remainingTime);
                return $remainingTime;
            }

            return 0; // Default return if no time tracking entry found
        }
    }



    public function loadCurrentQuestion()
    {
        $currentQuestionId = $this->questionIds[$this->currentQuestionIndex] ?? null;
        $this->currentQuestion = Question::find($currentQuestionId);

        if ($this->currentQuestion) {
            // Record start time for the current question
            TopicQuizTimeTracking::firstOrCreate(
                [
                    'topic_quiz_attempt_id' => $this->currentAttempt->id,
                    'question_id' => $this->currentQuestion->id,
                    'user_id' => auth()->user()->id,
                ],
                ['question_start_time' => now()]
            );

            $this->currentOptions = $this->currentQuestion->options()->get();
            // Calculate and dispatch the remaining time for the current question
            $this->remainingTime = $this->getRemainingTime();

            // dd($this->remainingTime);
            $this->dispatch('reset-timer', ['remainingTime' => $this->remainingTime]);
        } else {
            $this->currentOptions = [];
            // Handle no current question scenario
        }
    }

    #[On('timeUp')]
    public function handleTimeUp()
    {
        // Mark the current question as incorrect or unanswered
        // You can create a method to save the unanswered question here
        $remaining = $this->currentQuestionIndex < count($this->questionIds) - 1;
        // dd($remaining);
        // Check if there are more questions
        if ($remaining) {
            // There are more questions, go to next
            $this->goToNextQuestion();
            Log::info('next question called' . ' ' . $remaining);
            //log a message here so that I know the gotonextquestion is being called


        } else {
            Log::info('submit quiz called' . ' ' . $remaining);
            // Last question, submit the quiz
            $this->submitQuiz();
        }
    }

    public function goToNextQuestion()
    {
        if ($this->currentQuestionIndex < count($this->questionIds) - 1) {
            $this->currentQuestionIndex++;
            // Save the current question index to session
            // session()->put("currentQuestionIndex_{$this->topicId}", $this->currentQuestionIndex);
            $this->loadCurrentQuestion();
            // Reset the timer for the next question
            $this->resetTimerForNextQuestion();
        }
    }

    public function resetTimerForNextQuestion()
    {
        if (isset($this->currentQuestion)) {
            // $this->remainingTime = $this->currentQuestion->duration * 60; // Assuming duration is in minutes
            // Dispatch an event to reset the timer in the front end
            $this->dispatch('reset-timer', remainingTime: $this->getRemainingTime());
        }
    }



    public function goToPreviousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            // session()->put("currentQuestionIndex_{$this->topicId}", $this->currentQuestionIndex);
            $this->loadCurrentQuestion();
            $this->resetTimerForNextQuestion();
        }
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
        if ($this->currentAttempt) {
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

            if ($passed) {
                // Flash a success message and unlock the next topic
                $this->unlockNextTopic(auth()->id(), $this->currentAttempt->topic_id);
                session()->flash('message', 'Congratulations! You have passed the quiz and the next topic is now unlocked.');
            } else {
                // Flash a failure message and encourage the user to try again
                session()->flash('error', 'Unfortunately, you did not pass. Please review the topic and try the quiz again.');
            }
            // session()->forget("currentQuestionIndex_{$this->topicId}"); // Clear the session value
            // After the quiz is submitted, hide the quiz and show the message
            $this->showQuiz = false;
        }
    }

    public function render()
    {
        return view('livewire.topic-quiz');
    }
}
