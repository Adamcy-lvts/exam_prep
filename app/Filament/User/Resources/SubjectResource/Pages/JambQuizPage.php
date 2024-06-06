<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\WithPagination;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; 
use Filament\Notifications\Notification;
use App\Filament\User\Resources\SubjectResource;

class JambQuizPage extends Page
{
    protected static string $resource = SubjectResource::class;

    // protected static string $view = 'filament.user.resources.subject-resource.pages.jamb-quiz-page';

    // use WithPagination;

    public $subjects;
    public $compositeSessionId;
    public $subjectSessions;
    public $activeTab;
    public $tabWidthPercent;
    public $translateXPercent;
    public $sortedSubjects;
    public $ongoingAttempt;
    public $compositeQuizSession;
    public $remainingTime;
    public $user;
    public $quiz;
    public $currentTab;

    protected $listeners = ['timesUp' => 'submitQuiz'];

    public function mount($compositeSessionId): void
    {
        $this->user = auth()->user();
        $this->compositeSessionId = $compositeSessionId;
        $this->compositeQuizSession = CompositeQuizSession::findOrFail($this->compositeSessionId);
        $this->subjects = Auth::user()->subjects;

        // Sort the subjects by id
        $this->sortedSubjects = $this->subjects->sortBy('id')->values();
        $this->activeTab = session('lastSubjectId', $this->sortedSubjects->first()->id ?? null);


        foreach ($this->subjects as $subject) {
            $this->initializeSubjectSession($subject);
        }

        // Restore additional state as needed, such as the current question.
        // $lastQuestionId = session('lastQuestionId');
        // $lastAttemptId = session('lastAttemptId');

        static::authorizeResourceAccess();

        $this->remainingTime = $this->getRemainingTime();

        // dd($this->remainingTime);
    }

    #[On('updateActiveTab')] 
    public function updateActiveTab($subjectId)
    {
        logger($subjectId);
        session(['lastSubjectId' => $subjectId]);
        $this->currentTab = $subjectId;
        $this->dispatch('tabSwitched', $subjectId); // Optional: if you need to handle something on tab switch
    }


    private function initializeSubjectSession($subject)
    {
        $this->quiz = $this->initializeQuizForSubject($subject);

        $attempt = $this->initializeQuizAttempt($this->quiz->id);

        $this->subjectSessions[$subject->id] = [

            'attempt' => $attempt,
        ];
    }

    private function initializeQuizForSubject($subject)
    {
        // Find or create a quiz record for each subject
        return Quiz::firstOrCreate([
            'quizzable_id' => $subject->id,
            'quizzable_type' => get_class($subject),
        ], [
            'title' => $subject->name . ' Quiz',
            'duration' => 120, // example duration
            'total_marks' => 100, // example total marks
            'total_questions' => $subject->questions->count(),
            'max_attempts' => $this->compositeQuizSession->allowed_attempts,
        ]);
    }

    private function initializeQuizAttempt($quizId)
    {
        $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('composite_quiz_session_id', $this->compositeSessionId)
            ->where('quiz_id', $quizId)
            ->whereNull('end_time')
            ->first();

        if ($ongoingAttempt) {
            // Return the ongoing attempt and handle notification elsewhere.
            return $ongoingAttempt;
        }

        $completedAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('composite_quiz_session_id', $this->compositeSessionId)
            ->where('quiz_id', $quizId)
            ->whereNotNull('end_time')
            ->first();

        if ($completedAttempt) {
            // Return the completed attempt and handle notification elsewhere.
            return $completedAttempt;
        }

        // Create a new attempt.
        return QuizAttempt::create([
            'quiz_id' => $quizId,
            'composite_quiz_session_id' => $this->compositeSessionId,
            'user_id' => Auth::id(),
            'start_time' => now(),
            'score' => 0,
        ]);
    }

    public function getRemainingTime()
    {

        // $quizSession = $this->getLatestSession($this->quizzable->quizzable_id, $this->quizzable->quizzable_type);

        if ($this->compositeQuizSession) {
            $startTime = $this->compositeQuizSession->start_time;
            $duration = $this->compositeQuizSession->duration * 60 * 1000;  // Convert duration to milliseconds
            $elapsedTime = now()->diffInSeconds($startTime) * 1000;  // Convert to milliseconds

            $remainingTime = max(0, $duration - $elapsedTime);

            // $this->dispatch('timerUpdated', $remainingTime)->to(Timer::class);
            return $remainingTime;
        }

        return 0;  // Quiz session not found
    }

    public function timesUp()
    {
        $this->submitQuiz();
    }

    public function submitQuiz()
    {
        $user = auth()->user();

        try {
            $compositeScore = 0;

            foreach ($this->subjectSessions as $subjectId => $sessionDetails) {
                $attempt = $sessionDetails['attempt'];



                // Retrieve the questions and user answers for this attempt.
                // Retrieve the subject model.
                $subject = $this->subjects->firstWhere('id', $subjectId);

                // Retrieve the questions and user answers for this attempt.
                $questions = Question::where('quizzable_id', $subject->id)->where('quizzable_type', get_class($subject))->get();

                // Calculate the score for this subject's attempt.
                $score = $this->calculateScoreForAttempt($questions, $attempt);

                // Update the individual QuizAttempt with the score.
                $attempt->score = $score;
                $attempt->end_time = now();
                $attempt->save();

                QuizAnswer::where('user_id', auth()->user()->id)
                ->where('quiz_attempt_id', $attempt->id) // Ensure we only target answers from the current session
                ->whereIn('question_id', $questions->pluck('id'))
                ->update(['completed' => true]);

                // Detach the questions from the attempt
                $attempt->questions()->detach();

                // Add to the composite score.
                $compositeScore += $score;

                // Update the CompositeQuizSession with the compositeScore and mark as completed.
                $compositeSession = CompositeQuizSession::find($this->compositeSessionId);
                $compositeSession->completed = true;
                $compositeSession->total_score = $compositeScore;
                $compositeSession->status = "completed";
                $compositeSession->save(); 

            }
         

            // After successful submission
            $this->user->useJambAttempts($this->user);

            QuizAttempt::where('composite_quiz_session_id', $this->compositeSessionId)->update(['status' => 'completed']);

            session()->forget(['lastAttemptId', 'lastQuestionId', 'lastSubjectId', 'ongoingSessionId']);

            // Redirect to the results page with the CompositeQuizSession ID.
            return redirect()->route('filament.user.resources.subjects.jamb-quiz-result', ['compositeSessionId' => $this->compositeSessionId]);
        } catch (\Exception $e) {
            // Log the error and notify the user.
            Log::error('Quiz submission failed: ' . $e->getMessage());
            session()->flash('error', 'Quiz submission failed.');
            return; // Optionally redirect back or to another page.
        }
        // This will hold the total score across all subjects.
      
    }

    private function calculateScoreForAttempt($questions, $attempt)
    {
        $score = 0;

        foreach ($questions as $question) {
            $userAnswer = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                ->where('question_id', $question->id)
                ->first();

            // Increment the score based on correctness and question marks.
            if ($userAnswer && $userAnswer->correct) {
                $score += $question->marks;
            }
        }

        return $score;
    }

    public function render(): View
    {
        $attempts = [];
        foreach ($this->subjectSessions as $subjectId => $sessionData) {
            $attempts[$subjectId] = $sessionData['attempt']->id;
        }
        
        return view('filament.user.resources.subject-resource.pages.jamb-quiz-page', [
            'sortedSubjects' => $this->sortedSubjects,
            'attempts' => $attempts,
        ])->layout($this->getLayout(), [
                'livewire' => $this,
                'maxContentWidth' => $this->getMaxContentWidth(),
                ...$this->getLayoutData(),
            ]);
    }

    // public function render(): View
    // {
       

    //     return view('filament.user.resources.subject-resource.pages.jamb-quiz-page', [
    //         'sortedSubjects' => $this->sortedSubjects,
    //         'attempts' => $attempts,
    //     ])->layout(static::$layout, [
    //         'livewire' => $this,
    //         'maxContentWidth' => $this->getMaxContentWidth(),
    //         ...$this->getLayoutData(),
    //     ]);
    // }
}
