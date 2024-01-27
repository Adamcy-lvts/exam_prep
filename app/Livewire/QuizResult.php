<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CompositeQuizSession;

class QuizResult extends Component
{
    public $compositeSession;
    public $aggregateScore;

    public function mount($compositeSessionId)
    {
        $this->compositeSession = CompositeQuizSession::with('quizAttempts.quiz.quizzable')
        ->findOrFail($compositeSessionId);

        $this->calculateAggregateScore();
    }

    private function calculateAggregateScore()
    {
        $this->aggregateScore = $this->compositeSession->quizAttempts->sum('score');
        // dd($this->aggregateScore);
    }

    public function render()
    {
        return view('livewire.quiz-result', [
            'compositeSession' => $this->compositeSession,
            'aggregateScore' => $this->aggregateScore
        ]);
    }
}
