<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Subscription as Subscribers;
use App\Models\Subject;
use App\Models\Course;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        
        return [
            Stat::make('Total number of users', User::count())
            ->description('Number of registered users')
            ->descriptionIcon('heroicon-o-user-group')
            ->color('primary'),

            Stat::make('Total number of active subscribers', Subscribers::where('status', 'active')->count())
            ->description('Number of active subscriptions')
            ->descriptionIcon('heroicon-o-credit-card')
            ->color('success'),

            Stat::make('Total number of subjects', Subject::count())
            ->description('Number of available subjects')
            ->descriptionIcon('heroicon-o-book-open')
            ->color('warning'),

            Stat::make('Total number of courses', Course::count())
            ->description('Number of available courses')
            ->descriptionIcon('heroicon-o-academic-cap')
            ->color('info'),
        ];
    }
}
