<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserRegistrationChart extends ChartWidget
{

    protected static ?string $heading = 'User Registration Trend';
    protected static string $color = 'primary';

    protected function getData(): array
    {
        $period = $this->filters['period'] ?? 'month';

        $data = Trend::model(User::class)
            ->between(
                start: now()->subMonths($period === 'month' ? 6 : 5),
                end: now(),
            );

        if ($period === 'month') {
            $data = $data->perMonth();
        } else {
            $data = $data->perYear();
        }

        $data = $data->count();

        return [
            'datasets' => [
                [
                    'label' => 'User Registrations',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format($period === 'month' ? 'F' : 'Y')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
           
            'month' => 'By Months',
            'year' => 'By Year',
        ];
    }
}
