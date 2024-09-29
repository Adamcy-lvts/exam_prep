<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\UserQuizAttempt;
use Filament\Resources\Pages\Page;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use App\Filament\User\Resources\SubjectResource;

class JambQuizResult extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.jamb-quiz-result';

    public $compositeSession;
    public $aggregateScore;
    public $remainingAttempts;
    public $attempts;
    public $user;
    public $subjectReviews;
    public $totalQuestions;
    public $totalCorrectAnswers;
    public $totalIncorrectAnswers;
    public $totalUnansweredQuestions;

    public function mount($compositeSessionId): void
    {
        static::authorizeResourceAccess();

        $this->compositeSession = CompositeQuizSession::with('quizAttempts.quiz.quizzable', 'quizAttempts.answers')->findOrFail($compositeSessionId);

        if ($this->compositeSession) {
            $this->user = Auth::user();
            $this->attempts = $this->compositeSession->allowed_attempts;
            $attempt = $this->user->jambAttempts->attempts_left ?? 0;
            $this->remainingAttempts = $attempt;

            $this->calculateAggregateScore();
            $this->generateSubjectReviews();
            $this->calculateOverallStats();
        } else {
            $this->redirectRoute('filament.user.pages.dashboard');
        }
    }

    private function calculateAggregateScore()
    {
        $this->aggregateScore = $this->compositeSession->quizAttempts->sum('score');
    }

    private function generateSubjectReviews()
    {
        $this->subjectReviews = $this->compositeSession->quizAttempts->mapWithKeys(function ($attempt) {
            $subject = $attempt->quiz->quizzable;
            $totalQuestions = 50; // Fixed number of questions per subject
            $answers = $attempt->answers;

            $correctAnswers = $answers->where('correct', true)->count();
            $incorrectAnswers = $answers->where('correct', false)->count();
            $unansweredQuestions = $totalQuestions - ($correctAnswers + $incorrectAnswers);

            $score = $correctAnswers * 2; // Each question is worth 2 marks

            return [$subject->name => [
                'name' => $subject->name,
                'score' => $score,
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
                'incorrectAnswers' => $incorrectAnswers,
                'unansweredQuestions' => $unansweredQuestions,
                'percentageScore' => ($score / 100) * 100, // Score is already out of 100
                'performance' => $this->getPerformanceLevel($score, 100),
                'recommendations' => $this->getRecommendations($score, 100),
                'questions' => $this->getQuestions($attempt),
            ]];
        })->toArray();
    }

    private function calculateOverallStats()
    {
        $this->totalQuestions = array_sum(array_column($this->subjectReviews, 'totalQuestions'));
        $this->totalCorrectAnswers = array_sum(array_column($this->subjectReviews, 'correctAnswers'));
        $this->totalIncorrectAnswers = array_sum(array_column($this->subjectReviews, 'incorrectAnswers'));
        $this->totalUnansweredQuestions = array_sum(array_column($this->subjectReviews, 'unansweredQuestions'));
    }

    private function getQuestions($attempt)
    {
        return $attempt->quiz->questions->take(50)->map(function ($question) use ($attempt) {
            $userAnswer = $question->answers->where('quiz_attempt_id', $attempt->id)->first();
            return [
                'id' => $question->id,
                'question' => $question->question,
                'options' => $question->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'option' => $option->option,
                        'is_correct' => $option->is_correct,
                    ];
                }),
                'user_answer' => $userAnswer ? $userAnswer->option_id : null,
                'explanation' => $question->explanation,
            ];
        });
    }

    private function getPerformanceLevel($score, $totalMarks)
    {
        $percentage = ($score / $totalMarks) * 100;

        if ($percentage >= 80) return 'Excellent';
        if ($percentage >= 70) return 'Very Good';
        if ($percentage >= 60) return 'Good';
        if ($percentage >= 50) return 'Fair';
        return 'Needs Improvement';
    }

    private function getRecommendations($score, $totalMarks)
    {
        $percentage = ($score / $totalMarks) * 100;

        if ($percentage >= 80) {
            return "Great job! Keep up the excellent work. Focus on maintaining your current level of understanding.";
        } elseif ($percentage >= 70) {
            return "Well done! Review the few questions you missed to aim for an even higher score next time.";
        } elseif ($percentage >= 60) {
            return "Good effort! Identify the topics where you lost points and spend some time reinforcing those areas.";
        } elseif ($percentage >= 50) {
            return "You're on the right track. Dedicate more time to studying, focusing on the areas where you struggled the most.";
        } else {
            return "Don't be discouraged. Review your study materials thoroughly and consider seeking additional help or resources for this subject.";
        }
    }
}
