<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\QuizSession;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuizSessionResource\Pages;
use App\Filament\Resources\QuizSessionResource\RelationManagers;

class QuizSessionResource extends Resource
{
    protected static ?string $model = QuizSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DateTimePicker::make('start_time'),
                TextInput::make('duration')->label('Duration(Minutes)'),
                TextInput::make('allowed_attempts')->label('Number of Attempts'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('User')->view('filament.tables.columns.full-name'),
                TextColumn::make('course.title'),
                TextColumn::make('course.course_code'),
                TextColumn::make('start_time')->dateTime('g:i A'),
                TextColumn::make('duration'),
                TextColumn::make('allowed_attempts')->numeric(),
                ToggleColumn::make('completed'),
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
            'index' => Pages\ListQuizSessions::route('/'),
            'create' => Pages\CreateQuizSession::route('/create'),
            'edit' => Pages\EditQuizSession::route('/{record}/edit'),
        ];
    }
}
