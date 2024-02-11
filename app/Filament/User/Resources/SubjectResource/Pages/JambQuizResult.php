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

    public function mount($compositeSessionId): void
    {
        static::authorizeResourceAccess();

        $this->compositeSession = CompositeQuizSession::with('quizAttempts.quiz.quizzable')->findOrFail($compositeSessionId);

        if ($this->compositeSession) {
            $this->user = Auth::user();

            // $attemptCount = UserQuizAttempt::where('user_id', $user->id)
            //     ->count();

            $this->attempts = $this->compositeSession->allowed_attempts;
            // Check if the user has exceeded the allowed attempts

            $attempt = $this->user->jambAttempts->attempts_left ?? 0;
            $this->remainingAttempts = $attempt;

            $this->calculateAggregateScore();
        } else {
            $this->redirectRoute('filament.user.pages.dashboard');
        }
    }

    private function calculateAggregateScore()
    {
        $this->aggregateScore = $this->compositeSession->quizAttempts->sum('score');
    }
}
