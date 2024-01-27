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

    public function mount($compositeSessionId): void
    {
        static::authorizeResourceAccess();

        $this->compositeSession = CompositeQuizSession::with('quizAttempts.quiz.quizzable')
        ->findOrFail($compositeSessionId);

        $user = Auth::user();

        $attemptCount = UserQuizAttempt::where('user_id', $user->id)
            ->count();

        $this->attempts = $this->compositeSession->allowed_attempts;
        // Check if the user has exceeded the allowed attempts
        $this->remainingAttempts =  $this->attempts - $attemptCount;

        $this->calculateAggregateScore();
    }

    private function calculateAggregateScore()
    {
        $this->aggregateScore = $this->compositeSession->quizAttempts->sum('score');
   
    }

}
