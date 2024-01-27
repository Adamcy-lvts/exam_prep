<?php

namespace App\Filament\User\Widgets;

use App\Models\QuizAttempt;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CourseScoreChart extends ChartWidget
{
    protected static ?string $heading = 'Scores by Attempt';

    
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $userId = Auth::id(); // Get the currently authenticated user's ID
        $courseId = 1; // The specific course ID you're interested in

        // Get the scores for each attempt ordered by attempt number
        $attempts = QuizAttempt::where('user_id', $userId)
            ->where('quiz_id', $courseId)
            ->orderBy('id', 'asc') // Assuming 'id' increments with each attempt
            ->get(['id', 'score']);

        // Generate labels as 'Attempt 1', 'Attempt 2', etc.
        $labels = $attempts->map(function ($attempt, $key) {
            return 'Attempt ' . ($key + 1);
        });

        return [
            'datasets' => [
                [
                    'label' => 'Score',
                    'data' => $attempts->pluck('score')->all(),
                    'fill' => false,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1
                ],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
