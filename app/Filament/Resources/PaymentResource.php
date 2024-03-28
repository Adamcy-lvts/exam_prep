<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User & Subscription Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->relationship(
                    name: 'user',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('plan_id')->relationship(
                    name: 'plan',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('title')->orderBy('price'),
                )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->type} {$record->title} {$record->price}")
                    ->searchable(['type', 'title'])->preload(),

                Select::make('method')->options([
                    'card' => 'Card',
                    'bank' => 'Bank Transfer',
                    'cash' => 'Cash',
                    'pos' => 'POS',
                ])->default('card'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('Full Name')->view('filament.tables.columns.full-name'),
                TextColumn::make('amount')->money('NGN', true)->sortable()->copyable()->searchable(),
                TextColumn::make('method'),
                TextColumn::make('plan.type')->label('Plan Type'),
                TextColumn::make('plan.title')->label('Plan Title'),
                TextColumn::make('user.email')->label('Email Address')->searchable(),
                TextColumn::make('created_at')->label('Payment Date')->dateTime('F j, Y g:i A'),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
