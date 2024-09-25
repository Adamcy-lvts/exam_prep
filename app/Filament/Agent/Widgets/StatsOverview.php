<?php

namespace App\Filament\Agent\Widgets;

use App\Models\SchoolRegistrationLink;
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

        // Check if the agent has a valid school registration link
        $hasValidSchoolLink = SchoolRegistrationLink::where('agent_id', $agent->id)
            ->where('expires_at', '>', now())
            ->exists();

        return $hasValidSchoolLink ? $this->getSchoolStats($agent) : $this->getIndividualAgentStats($agent);
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
            Stat::make('Total Revenue Generated', formatNaira($totalRevenue))
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

        return [
            Stat::make('Total Referred Users', $totalReferredUsers)
                ->description('Number of users referred by you')
                ->descriptionIcon('heroicon-o-users')
                ->color('primary'),
            Stat::make('Total Subscriptions', $totalSubscriptions)
                ->description('Number of subscriptions excluding the free plan')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('success'),
            Stat::make('Total Commission Earned', formatNaira($totalCommission))
                ->description('Total commission earned from referrals')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('info'),
        ];
    }
}
