<?php

namespace App\Filament\Agent\Widgets;

use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $agent = Auth::user()->agent;

        // Total referred users
        $totalReferredUsers = $agent->referredUsers()->count();

        // Total subscriptions (excluding the free plan)
        $totalSubscriptions = $agent->referredUsers()->withCount(['subscriptions' => function ($query) {
            $query->where('plan_id', '!=', 1);
        }])->get()->sum('subscriptions_count');

        // Total commission earned (assuming you have a method to calculate it)
        $totalCommission = $agent->referredUsers()->with(['subscriptions' => function ($query) {
            $query->where('plan_id', '!=', 1);
        }])->get()->reduce(function ($carry, $user) {
            return $carry + $user->subscriptions->sum('commission_amount'); // Adjust based on your commission calculation logic
        }, 0);

        return [
            Stat::make('Total Referred Users', $totalReferredUsers)
                ->description('Number of users referred by you')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Total Subscriptions', $totalSubscriptions)
                ->description('Number of subscriptions excluding the free plan')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('success'),
            Stat::make('Total Commission Earned', number_format($totalCommission, 2) . ' NGN')
                ->description('Total commission earned from referrals')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('info'),
        ];
    }
}
