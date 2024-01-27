<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Livewire\WithPagination;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
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

    public function mount($compositeSessionId): void
    {
        $this->compositeSessionId = $compositeSessionId;
        $this->subjects = Auth::user()->subjects;
        // Sort the subjects by id
        $this->sortedSubjects = $this->subjects->sortBy('id')->values();
        $this->activeTab = $this->sortedSubjects->first()->id ?? null;

        foreach ($this->subjects as $subject) {
            $this->initializeSubjectSession($subject);
        }

        static::authorizeResourceAccess();
    }

    private function initializeSubjectSession($subject)
    {
        $quiz = $this->initializeQuizForSubject($subject);

        $attempt = $this->initializeQuizAttempt($quiz->id);

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
            'max_attempts' => 3,
        ]);
    }

    private function initializeQuizAttempt($quizId)
    {

        $this->ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
            ->where('composite_quiz_session_id', $this->compositeSessionId)->where('quiz_id', $quizId)
            ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
            ->first();

        if ($this->ongoingAttempt) {
            return $this->ongoingAttempt;
        }

        // If no ongoing attempt, create a new one
        return QuizAttempt::create([
            'quiz_id' => $quizId,
            'composite_quiz_session_id' => $this->compositeSessionId,
            'user_id' => Auth::id(),
            'start_time' => now(),
            'score' => 0,
        ]);
    }

    public function submitQuiz()
    {
        // This will hold the total score across all subjects.
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

            // Add to the composite score.
            $compositeScore += $score;

            // Update the CompositeQuizSession with the compositeScore and mark as completed.
            $compositeSession = CompositeQuizSession::find($this->compositeSessionId);
            $compositeSession->completed = true;
            $compositeSession->total_score = $compositeScore;
            $compositeSession->save();
        }


        // Redirect to the results page with the CompositeQuizSession ID.
        return redirect()->route('filament.user.resources.subjects.jamb-quiz-result', ['compositeSessionId' => $this->compositeSessionId]);
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
        ])->layout(static::$layout, [
            'livewire' => $this,
            'maxContentWidth' => $this->getMaxContentWidth(),
            ...$this->getLayoutData(),
        ]);
    }
}
