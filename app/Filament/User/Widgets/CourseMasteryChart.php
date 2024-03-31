<?php

namespace App\Filament\User\Widgets;

use App\Models\Course;
use App\Models\QuizAttempt;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class CourseMasteryChart extends ChartWidget
{
    protected static ?string $heading = 'Course Mastery';

    protected static ?int $sort = 2;

    public static function canView(): bool
    {
        return Auth::user()->can('view_course') || Auth::user()->can('view_any_course');
    }

    protected function getData(): array
    {
        $userId = auth()->id(); // Fetches the current user ID

        // Fetch subjects registered by the user
        $registeredCourses = Course::whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();

        $labels = $registeredCourses->pluck('course_code'); // Get names of subjects for the chart labels

        // Prepare the datasets for the chart
        $data = $registeredCourses->map(function ($course) use ($userId) {
            // Get average score for each registered course based on quiz attempts
            $averageScore = QuizAttempt::whereHas('quiz', function ($query) use ($course) {
                $query->where('quizzable_id', $course->id)
                    ->where('quizzable_type', Course::class);
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
        return 'bar';
    }
}
