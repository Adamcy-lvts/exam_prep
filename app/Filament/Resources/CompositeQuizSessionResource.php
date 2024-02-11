<?php

namespace App\Filament\Resources;

use DateTime;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\CompositeQuizSession;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CompositeQuizSessionResource\Pages;
use App\Filament\Resources\CompositeQuizSessionResource\RelationManagers;

class CompositeQuizSessionResource extends Resource
{
    protected static ?string $model = CompositeQuizSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('user_id')->hidden(),
                TimePicker::make('start_time'),
                TimePicker::make('end_time'),
                TextInput::make('duration')->numeric(),
                TextInput::make('total_score')->numeric(),
                TextInput::make('allowed_attempts')->numeric()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.first_name'),
                TextColumn::make('quizAttempts.quiz.title'),
                TextColumn::make('start_time'),
                TextColumn::make('completed'),
                TextColumn::make('total_score'),
                TextColumn::make('allowed_attempts'),

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
            'index' => Pages\ListCompositeQuizSessions::route('/'),
            'create' => Pages\CreateCompositeQuizSession::route('/create'),
            'edit' => Pages\EditCompositeQuizSession::route('/{record}/edit'),
        ];
    }
}
