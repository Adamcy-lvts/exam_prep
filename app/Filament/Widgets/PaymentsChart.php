<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Payment;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class PaymentsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Amount by month ';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Assuming you have a 'Payment' model
        $data = Trend::model(Payment::class)
            ->between(
                start: now()->subMonths(6), // Last 6 months
                end: now()
            )
            ->perMonth()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Total Payments',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    // 'backgroundColor', 'borderColor' for colors (optional) 
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'past_6_months' => 'Past 6 Months',
            'past_year' => 'Past Year',
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
