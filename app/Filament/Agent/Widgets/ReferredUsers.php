<?php

namespace App\Filament\Agent\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms;

class ReferredUsers extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                TextColumn::make('referred_at')
                    ->label('Referred At')
                    ->date()
                    ->sortable(),

                TextColumn::make('subscription_plan')
                    ->label('Subscription Plan')
                    ->getStateUsing(function ($record) {
                        $activeSubscription = $record->subscriptions()
                            ->where('status', 'active')
                            ->where('ends_at', '>', now())
                            ->first();
                        return $activeSubscription ? $activeSubscription->plan->title : 'No active plan';
                    }),

                TextColumn::make('subscription_status')
                    ->label('Subscription Status')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        $activeSubscription = $record->subscriptions()
                            ->where('status', 'active')
                            ->where('ends_at', '>', now())
                            ->first();
                        return $activeSubscription ? 'Active' : 'Inactive';
                    })
                    ->colors([
                        'success' => 'Active',
                        'danger' => 'Inactive',
                    ]),

                TextColumn::make('subscriptions_count')
                    ->label('Total Subscriptions')
                    ->counts('subscriptions', fn(Builder $query) => $query->where('plan_id', '!=', 1))
                    ->sortable(),

                TextColumn::make('total_payments')
                    ->label('Total Payments')
                    ->getStateUsing(function ($record) {
                        return 'NGN ' . number_format($record->referralPayments->sum('amount'), 2);
                    })
                    ->sortable(),
            ])
            ->defaultSort('referred_at', 'desc')
            ->filters([
                SelectFilter::make('user_type')
                    ->options([
                        'student' => 'Student',
                        'school' => 'School',
                        'agent' => 'Agent',
                    ]),
                SelectFilter::make('subscription_status')
                    ->options([
                        'active' => 'Active',
                        'cancelled' => 'Cancelled',
                        'paused' => 'Paused',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (isset($data['value'])) {
                            $query->whereHas('subscriptions', function ($q) use ($data) {
                                $q->where('status', $data['value']);
                            });
                        }
                    }),
                Filter::make('referred_at')
                    ->form([
                        Forms\Components\DatePicker::make('referred_from'),
                        Forms\Components\DatePicker::make('referred_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['referred_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('agent_user.referred_at', '>=', $date),
                            )
                            ->when(
                                $data['referred_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('agent_user.referred_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                // Add any actions you want to perform on each row
            ])
            ->bulkActions([
                // Add any bulk actions you want to perform on selected rows
            ]);
    }

    protected function getTableQuery(): Builder
    {
        $user = auth()->user();

        if ($user->user_type !== 'agent' || !$user->agent) {
            return User::query()->whereNull('id'); // Return an empty query if not an agent
        }

        return User::query()
            ->join('agent_user', 'users.id', '=', 'agent_user.user_id')
            ->where('agent_user.agent_id', $user->agent->id)
            ->select('users.*', 'agent_user.referred_at')
            ->withCount('subscriptions')
            ->with(['latestSubscription', 'referralPayments']);
    }
}
