<?php

namespace App\Filament\Agent\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ReferredUsers extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        $agent = auth()->user()->agent; // Assuming the authenticated user is linked to an agent

        return $table
            ->relationship(fn (): BelongsToMany => $agent->referredUsers())
            ->inverseRelationship('referringAgents')
            ->columns([
                TextColumn::make('first_name')->label('First Name'),
                TextColumn::make('last_name')->label('Last Name'),
                TextColumn::make('email')->label('Email'),
                TextColumn::make('pivot.referred_at')->label('Referred At')->date(),
                TextColumn::make('user.subscription')
                    ->label('Subscription Count')
                    ->getStateUsing(fn ($record) => $record->subscriptions()->where('plan_id', '!=', 1)->count())
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state === 0 => 'gray',
                        $state > 0 && $state <= 5 => 'warning',
                        $state > 5 => 'success',
                        default => 'secondary',
                    }),
            ]);
    }
}
