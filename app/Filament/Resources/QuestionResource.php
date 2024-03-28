<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Question;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MorphToSelect;
use App\Filament\Resources\QuestionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QuestionResource\RelationManagers;
use Filament\Forms\Components\RichEditor;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')->required(),
                Select::make('quiz_id')->relationship(name: 'quiz', titleAttribute: 'title'),
                TextInput::make('marks')->numeric(),
                TextInput::make('duration')->numeric(),
                MorphToSelect::make('quizzable')
                    ->types([
                        MorphToSelect\Type::make(Subject::class)
                            ->titleAttribute('name'),
                        MorphToSelect\Type::make(Course::class)
                            ->titleAttribute('title'),
                    ]),
                
                Select::make('topic_id')->relationship(name: 'topic', titleAttribute: 'name'),
                Radio::make('type')->options([
                    Question::TYPE_MCQ => 'MCQ',
                    Question::TYPE_SAQ => 'SAQ',
                    Question::TYPE_TF => 'TF',
                ])->required(),
                TextInput::make('answer_text'),
                RichEditor::make('explanation')->columnSpan(2),
                Repeater::make('options')
                    ->schema([
                        TextInput::make('option')->required(),
                        Radio::make('is_correct')
                            ->options([
                                1 => 1,
                            ])
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        // Only render the tooltip if the column content exceeds the length limit.
                        return $state;
                    }),
                TextColumn::make('quizzable.name'),
                TextColumn::make('marks')
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
