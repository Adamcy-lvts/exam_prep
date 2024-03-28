<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use App\Models\Quiz;
use Filament\Tables;
use App\Models\Course;
use App\Models\Subject;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MorphToSelect;
use App\Filament\Resources\QuizResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuizResource\RelationManagers;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Quiz Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->unique(ignoreRecord: true),
              
                MorphToSelect::make('quizzable')
                    ->types([
                        MorphToSelect\Type::make(Subject::class)
                            ->titleAttribute('name'),
                        MorphToSelect\Type::make(Course::class)
                            ->titleAttribute('title'),
                    ])->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {
                        $quizzableType = $get('quizzable_type');
                        $quizzableId = $get('quizzable_id');

                        if ($quizzableType && $quizzableId) {
                            $quizzableClass = $quizzableType === Subject::class ? Subject::class : Course::class;
                            $quizzableInstance = $quizzableClass::find($quizzableId);

                            if ($quizzableInstance) {
                                $title = $quizzableInstance->name ?? $quizzableInstance->title;
                                $set('title', $title);
                            }
                        }
                    }),
                TextInput::make('total_marks')->numeric(),
                TextInput::make('duration')->numeric(),
                TextInput::make('max_attempts')->numeric(),
                TextInput::make('total_questions')->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('quizzable_type'),
                TextColumn::make('total_marks'),
                TextColumn::make('duration'),
                TextColumn::make('max_attempts')->numeric(),
                TextColumn::make('total_questions'),

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
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
