<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Subscription;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SubscriptionResource\Pages;
use App\Filament\Resources\SubscriptionResource\RelationManagers;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User & Subscription Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')->label('Subscriber'),
                TextInput::make('plan_id')->label('Plan'),
                TextInput::make('status')->label('Status'),
                DatePicker::make('starts_at')->label('Starts At'),
                DatePicker::make('ends_at')->label('Ends At'),
                DatePicker::make('cancelled_at')->label('Cancelled At'),
                TextInput::make('is_recurring')->label('Is Recurring'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('Subscriber')->view('filament.tables.columns.full-name'),
                TextColumn::make('plan.title')->label('Plan'),
                TextColumn::make('status')->label('Status')->badge()
                    ->color(fn (string $state): string => match ($state) {

                        'active' => 'success',
                        'expired' => 'danger',
                        'cancelled' => 'warning',
                    }),
                TextColumn::make('starts_at')->label('Starts At')->dateTime('Y-m-d' . ' ' . 'H:i:s'),
                TextColumn::make('ends_at')->label('Ends At')->dateTime('Y-m-d' . ' ' . 'H:i:s'),
                TextColumn::make('cancelled_at')->label('Cancelled At')->dateTime('Y-m-d' . ' ' . 'H:i:s'),
                TextColumn::make('is_recurring')->label('Is Recurring'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
