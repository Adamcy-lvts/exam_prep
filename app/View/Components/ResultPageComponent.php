<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ResultPageComponent extends Component
{

    public $questions;
    public $totalScore;
    public $totalMarks;
    public $formattedTimeSpent;
    public $answeredCorrectQuestions;
    public $answeredWrongQuestions;
    public $unansweredQuestions;
    public $quizzable;
    public $remainingAttempts;
    public $organizedPerformances;
    public $testAnswers;
    /**
     * Create a new component instance.
     */
    public function __construct($questions, $totalScore, $totalMarks, $formattedTimeSpent, $answeredCorrectQuestions, $answeredWrongQuestions, $unansweredQuestions, $quizzable, $remainingAttempts, $organizedPerformances, $testAnswers)
    {
        $this->questions = $questions;
        $this->totalScore = $totalScore;
        $this->totalMarks = $totalMarks;
        $this->formattedTimeSpent = $formattedTimeSpent;
        $this->answeredCorrectQuestions = $answeredCorrectQuestions;
        $this->answeredWrongQuestions = $answeredWrongQuestions;
        $this->unansweredQuestions = $unansweredQuestions;
        $this->quizzable = $quizzable;
        $this->remainingAttempts = $remainingAttempts;
        $this->organizedPerformances = $organizedPerformances;
        $this->testAnswers = $testAnswers;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.result-page-component');
    }
}
