<?php

namespace App\Filament\User\Widgets;

use App\Models\Subject;
use App\Models\QuizAttempt;
use Filament\Widgets\ChartWidget;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectMasteryChart extends ChartWidget
{
    protected static ?string $heading = 'Recent Subject Performance';

    public static function canView(): bool
    {
        return Auth::user()->can('view_subject') || Auth::user()->can('view_any_subject');
    }

    protected function getData(): array
    {
        $userId = auth()->id();

        // Fetch subjects registered by the user
        $registeredSubjects = Subject::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();

        $labels = $registeredSubjects->pluck('name');

        // Prepare the datasets for the chart
        $data = $registeredSubjects->map(function ($subject) use ($userId) {
            // Get the most recent attempt score for each registered subject
            $recentScore = QuizAttempt::whereHas('quiz', function ($query) use ($subject) {
                $query->where('quizzable_id', $subject->id)
                    ->where('quizzable_type', Subject::class);
            })
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->value('score');

            return $recentScore ? round($recentScore, 2) : null; // Return null if no attempt found
        });

        return [
            'datasets' => [
                [
                    'label' => 'Recent Score',
                    'backgroundColor' => '#4ade80',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 100,
                    'title' => [
                        'display' => true,
                        'text' => 'Score',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Subjects',
                    ],
                ],
            ],
            
        ];
    }
}