<?php

namespace App\Filament\Agent\Widgets;

use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = Auth::user();

        if ($user->user_type !== 'agent' || !$user->agent) {
            return $this->getNoAgentStats();
        }

        $agent = $user->agent;

        return $agent->is_school ? $this->getSchoolStats($agent) : $this->getIndividualAgentStats($agent);
    }

    protected function getNoAgentStats(): array
    {
        return [
            Stat::make('No Agent Account', 'N/A')
                ->description('You are not registered as an agent')
                ->color('danger'),
        ];
    }

    protected function getSchoolStats($agent): array
    {
        // Total registered students
        $totalRegisteredStudents = $agent->referredUsers()->count();

        // Total active subscriptions
        $totalActiveSubscriptions = $agent->referredUsers()
            ->whereHas('subscriptions', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        // Total revenue generated
        $totalRevenue = $agent->referralPayments()->sum('amount');

        return [
            Stat::make('Total Registered Students', $totalRegisteredStudents)
                ->description('Number of students registered through your link')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),
            Stat::make('Active Subscriptions', $totalActiveSubscriptions)
                ->description('Number of students with active subscriptions')
                ->descriptionIcon('heroicon-o-bookmark')
                ->color('success'),
            Stat::make('Total Revenue Generated', number_format($totalRevenue, 2) . ' NGN')
                ->description('Total revenue generated from student subscriptions')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('info'),
        ];
    }

    protected function getIndividualAgentStats($agent): array
    {
        // Total referred users
        $totalReferredUsers = $agent->referredUsers()->count();

        // Total subscriptions (excluding the free plan)
        $totalSubscriptions = $agent->referredUsers()
            ->whereHas('subscriptions', function ($query) {
                $query->where('plan_id', '!=', 1);
            })
            ->count();

        // Total commission earned from referral payments
        $totalCommission = $agent->referralPayments()->sum('amount');

        // Total referred schools
        $totalReferredSchools = $agent->referredSchools()->count();

        // Total revenue generated from referred schools
        $totalSchoolRevenue = $agent->referredSchools()
            ->withSum('referralPayments', 'amount')
            ->get()
            ->sum('referral_payments_sum_amount');

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
            Stat::make('Referred Schools', $totalReferredSchools)
                ->description('Number of schools registered through your link')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('warning'),
            Stat::make('School-Generated Revenue', number_format($totalSchoolRevenue, 2) . ' NGN')
                ->description('Total revenue generated from referred schools')
                ->descriptionIcon('heroicon-o-building-library')
                ->color('success'),
        ];
    }
}
