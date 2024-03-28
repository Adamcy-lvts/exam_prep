<?php

namespace App\Filament\User\Widgets;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use App\Models\CompositeQuizSession;
use App\Models\QuizAttempt;

class ScoreTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Detailed Score Trend Over Time';
    protected static ?string $pollingInterval = null; // Adjust as necessary
    public ?string $filter = 'week'; // Default filter to show the last week

    protected function getData(): array
    {
        
        $user = auth()->user(); // Fetches the current user ID

        if($user->isRegisteredForSubject()) {
            // Determine the start and end dates based on the filter
            if ($this->filter === 'today') {
                $startDate = now()->startOfDay();
                $endDate = now();
            } else {
                $startDate = $this->filter === 'week' ? now()->subWeek() : now()->subMonth();
                $endDate = now()->endOfDay();
            }

            // Fetch all scores for the user within the selected time frame
            $scores = CompositeQuizSession::where('user_id', $user->id)
                ->whereBetween('start_time', [$startDate, $endDate])
                ->orderBy('start_time', 'asc')
                ->get(['total_score', 'start_time']);

            // Prepare the data for the chart
            $data = $scores->map(function ($session) {
                return $session->total_score;
            });

            $labels = $scores->map(function ($session) {
                $startTime = Carbon::parse($session->start_time);
                $formattedDate = $startTime->isToday() ? 'Today' : ($startTime->isYesterday() ? 'Yesterday' :
                    $startTime->format('M d'));
                return $formattedDate . ' ' . $startTime->format('g:i A'); // Converts to 12-hour format with AM/PM
            });

            return [
                'datasets' => [
                    [
                        'label' => 'Score',
                        'data' => $data,
                    ],
                ],
                'labels' => $labels,
            ];
        } else {
            // Determine the start and end dates based on the filter
            if ($this->filter === 'today') {
                $startDate = now()->startOfDay();
                $endDate = now();
            } else {
                $startDate = $this->filter === 'week' ? now()->subWeek() : now()->subMonth();
                $endDate = now()->endOfDay();
            }

            // Fetch all scores for the user within the selected time frame
            $scores = QuizAttempt::where('user_id', $user->id)
                ->whereBetween('start_time', [$startDate, $endDate])
                ->orderBy('start_time', 'asc')
                ->get(['score', 'start_time']);

            // Prepare the data for the chart
            $data = $scores->map(function ($attempt) {
                return $attempt->score;
            });

            $labels = $scores->map(function ($attempt) {
                $startTime = Carbon::parse($attempt->start_time);
                $formattedDate = $startTime->isToday() ? 'Today' : ($startTime->isYesterday() ? 'Yesterday' :
                    $startTime->format('M d'));
                return $formattedDate . ' ' . $startTime->format('g:i A'); // Converts to 12-hour format with AM/PM
            });

            return [
                'datasets' => [
                    [
                        'label' => 'Score',
                        'data' => $data,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today', // Adding 'Today' as a filter option
            'week' => 'Last Week',
            'month' => 'Last Month',
        ];
    }
}
