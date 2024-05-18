<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Topic;
use App\Models\Option;
use App\Models\Question;
use App\Models\QuizAnswer;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\TopicQuizAttempt;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\TopicQuizTimeTracking;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\SubjectResource;

class TopicQuiz extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.topic-quiz';

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


    public $currentAttemptId;
    public $topicId;
    public $topic;

    public $currentAttempt;

    public $userTopics;
    public $unlockedTopics;
    public $subject;

    public $showQuiz = true;
    public $showSuccessMessage = false;
    public $showFailureMessage = false;
    public $successMessage = '';
    public $failureMessage = '';

    public $nextTopicName;


    public $timeLeftForCurrentQuestion;

    use WithPagination;

    public function mount($record)
    {

        $this->topicId = $record;
        $this->topic = Topic::with(['questions'])->findOrFail($record);
        // Attempt to fetch the latest quiz attempt for the current user
        $this->currentAttempt = $this->fetchLatestQuizAttempt();
        // dd($this->currentAttempt);
        // dd($this->currentAttempt->topic_id);
        if ($this->currentAttempt && !$this->currentAttempt->completed) {
            $this->currentTopicId = $this->currentAttempt->topic_id;
            $this->loadQuizStateFromAttempt();
        } else {

            $this->currentTopicId = null;
        }

        // If there is no existing attempt, create a new one
        if (!$this->currentAttempt) {

            $this->currentAttempt = TopicQuizAttempt::create([
                'user_id' => Auth::id(),
                'topic_id' => $this->topicId,
                'score' => 0, // initial score
                'passed' => false,
                'start_time' => now(),
                'completed' => false,
            ]);
        }

        // if ($this->currentAttempt) {
        //     $this->loadAnswers(); // Load previously saved answers
        // }
        if ($this->topic->topicable instanceof \App\Models\Subject) {

            $this->subject = $this->topic->topicable;
        }
        // Set up the quiz questions and state
        $this->questionIds = Question::where('topic_id', $this->topicId)->pluck('id')->toArray();

        if (!empty($this->questionIds)) {
            $this->loadCurrentQuestion();
        } else {
            session()->flash('error', 'Unfortunately, there are no questions for this topic yet, Please check back soon.');
        }

        $this->setNextTopic();
    }

    protected function setNextTopic()
    {
        $nextTopic = Topic::where('topicable_id', $this->topic->topicable_id)
            ->where('order', '>', $this->topic->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextTopic) {
            $this->nextTopicName = $nextTopic->name;
        } else {
            $this->nextTopicName = null; // or handle the end of course scenario
        }
    }


    protected function fetchLatestQuizAttempt()
    {
        // Fetch the latest quiz attempt for the current user that is not completed
        return TopicQuizAttempt::where('user_id', Auth::id())
            ->where('completed', false)->where('topic_id', $this->topicId)
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

    #[On('timesUp')]
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

            $this->showQuiz = false;

            if ($passed) {
                // Flash a success message and unlock the next topic
                $this->unlockNextTopic(auth()->id(), $this->currentAttempt->topic_id);
                $this->showSuccessMessage = true;
                $this->successMessage = 'Congratulations! You have passed the quiz and the next topic is now unlocked.';
                session()->flash('message', 'Congratulations! You have passed the quiz and the next topic is now unlocked.');
            } else {
                // Flash a failure message and encourage the user to try again
                $this->showFailureMessage = true;
                $this->failureMessage = 'Unfortunately, you did not pass. Please review the topic and try the quiz again.';
                session()->flash('error', 'Unfortunately, you did not pass. Please review the topic and try the quiz again.');
            }

            // return redirect()->route('filament.user.resources.subjects.lessons', ['subjectId' => $this->subject->id]);
            // session()->forget("currentQuestionIndex_{$this->topicId}"); // Clear the session value
            // After the quiz is submitted, hide the quiz and show the message

        }
    }


    public function unlockNextTopic($userId, $currentTopicId)
    {

        $nextTopic = $this->subject->topics
            ->where('order', '>', $this->currentAttempt->topic->order)
            ->first();

        if ($nextTopic) {
            // Update the unlocked status in the database
            DB::table('topic_users')->updateOrInsert(
                ['user_id' => $userId, 'topic_id' => $nextTopic->id],
                ['unlocked' => true]
            );

            // Update the unlocked status in the component state
            $nextTopicKey = $this->subject->topics->search(function ($topic) use ($nextTopic) {
                return $topic->id === $nextTopic->id;
            });

            if ($nextTopicKey !== false) {
                $this->subject->topics[$nextTopicKey]->unlocked = true;
            }

            // Notify the frontend to update the UI
            $this->dispatch('topicUnlocked', $nextTopic->id);
        }
    }


    #[On('topicUnlocked')]
    public function updateTopicUnlockedStatus($topicId)
    {

        $this->unlockedTopics = auth()->user()->topics()->where('unlocked', true)->pluck('topic_id');
    }

    public function getTitle(): string | Htmlable
    {
        return __($this->topic->name);
    }

    public function getHeading(): string
    {
        if ($this->showQuiz) {
            return __('You are currenlty taking quiz from' . ' ' . $this->subject->name . ' ' . 'on' . ' ' . $this->topic->name);
        } else {
            return "";
        }
    }

    public function getBreadcrumbs(): array
    {
        return [
            'lessons' => 'Subjects',
            $this->subject->name, $this->topic->name
        ];
        return [];
    }

    public function continueReading()
    {
        return redirect()->route('filament.user.resources.subjects.lessons', ['subjectId' => $this->subject->id]);
    }

    public function retakeQuiz()
    {
        return redirect()->route('filament.user.resources.subjects.topic-quiz', ['record' => $this->topicId]);
    }

    // public function getSubheading(): ?string
    // {
    //     return __($this->topic->name);
    // }
}
