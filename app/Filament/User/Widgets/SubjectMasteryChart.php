<?php

namespace App\Filament\User\Widgets;

use App\Models\Subject;
use App\Models\QuizAttempt;
use Filament\Widgets\ChartWidget;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;

class SubjectMasteryChart extends ChartWidget
{

    protected static ?string $heading = 'Subject Mastery';

    public static function canView(): bool
    {
        return Auth::user()->can('view_subject') || Auth::user()->can('view_any_subject');
    }

    protected function getData(): array
    {
        $userId = auth()->id(); // Fetches the current user ID

        // Fetch subjects registered by the user
        $registeredSubjects = Subject::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();

        $labels = $registeredSubjects->pluck('name'); // Get names of subjects for the chart labels

        // Prepare the datasets for the chart
        $data = $registeredSubjects->map(function ($subject) use ($userId) {
            // Get average score for each registered subject based on quiz attempts
            $averageScore = QuizAttempt::whereHas('quiz', function ($query) use ($subject) {
                $query->where('quizzable_id', $subject->id)
                    ->where('quizzable_type', Subject::class);
            })->where('user_id', $userId)
                ->average('score');

            return $averageScore ? round($averageScore, 2) : 0; // Round to 2 decimal places
        });

        return [
            'datasets' => [
                [
                    'label' => 'Average Score',
                    'backgroundColor' => '#4ade80', // Example color
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Use a bar chart to display subject mastery
    }
}
