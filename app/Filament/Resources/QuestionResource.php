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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Forms\Components\MorphToSelect;
use App\Filament\Resources\QuestionResource\Pages;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        TextInput::make('question')
                            ->required()
                            ->label('Question Text')
                            ->columnSpan('full'),

                        FileUpload::make('question_image')
                            ->image()
                            ->disk('public')
                            ->directory('questions-images')
                            ->visibility('public')
                            ->maxSize(5120) // 5MB limit
                            ->label('Question Image')
                            ->columnSpan('full'),

                        Forms\Components\Group::make()
                            ->schema([
                                Radio::make('type')
                                    ->options([
                                        Question::TYPE_MCQ => 'Multiple Choice',
                                        Question::TYPE_SAQ => 'Short Answer',
                                        Question::TYPE_TF => 'True/False',
                                    ])
                                    ->required()
                                    ->inline()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Forms\Set $set) => $set('options', [])),
                            ])
                            ->columnSpan('full'),

                        Forms\Components\Group::make()
                            ->schema([
                                Select::make('quiz_id')
                                    ->relationship('quiz', 'title')
                                    ->required()
                                    ->label('Quiz'),
                                TextInput::make('marks')
                                    ->numeric()
                                    ->required()
                                    ->default(1),
                            ])
                            ->columns(2),

                        Forms\Components\Group::make()
                            ->schema([
                                TextInput::make('duration')
                                    ->numeric()
                                    ->label('Duration (in seconds)')
                                    ->helperText('Leave empty for no time limit'),
                                MorphToSelect::make('quizzable')
                                    ->types([
                                        MorphToSelect\Type::make(Subject::class)->titleAttribute('name'),
                                        MorphToSelect\Type::make(Course::class)->titleAttribute('title'),
                                    ])
                                    ->required()
                                    ->label('Associated With'),
                            ])
                            ->columns(2),

                        Select::make('topic_id')
                            ->relationship('topic', 'name')
                            ->label('Topic')
                            ->columnSpan('full'),

                        Forms\Components\Repeater::make('options')
                            ->schema([
                                TextInput::make('option')
                                    ->required()
                                    ->label('Option'),
                                Forms\Components\Checkbox::make('is_correct')
                                    ->label('Correct'),
                            ])
                            ->columns(2)
                            ->grid(2)
                            ->columnSpan('full')
                            ->minItems(2)
                            ->maxItems(4)
                            ->hidden(fn(Forms\Get $get) => $get('type') !== Question::TYPE_MCQ)
                            ->relationship('options')
                            ->defaultItems(4),

                        TextInput::make('answer_text')
                            ->label('Correct Answer')
                            ->visible(fn(Forms\Get $get) => $get('type') === Question::TYPE_SAQ)
                            ->required(fn(Forms\Get $get) => $get('type') === Question::TYPE_SAQ)
                            ->default(fn($record) => $record?->answer_text)
                            ->columnSpan('full'),

                        Radio::make('answer_text')
                            ->label('Correct Answer')
                            ->options([
                                'true' => 'True',
                                'false' => 'False',
                            ])
                            ->inline()
                            ->visible(fn(Forms\Get $get) => $get('type') === Question::TYPE_TF)
                            ->required(fn(Forms\Get $get) => $get('type') === Question::TYPE_TF)
                            ->columnSpan('full'),

                        RichEditor::make('explanation')

                            ->columnSpan('full'),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question')
                    ->limit(50)
                    ->searchable()
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        return strlen($state) > 50 ? $state : null;
                    }),
                TextColumn::make('type')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'mcq' => 'Multiple Choice',
                        'saq' => 'Short Answer',
                        'tf' => 'True/False',
                        default => $state,
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'mcq' => 'success',
                        'saq' => 'warning',
                        'tf' => 'info',
                        default => 'primary',
                    }),
                TextColumn::make('quizzable')
                    ->label('Associated With')
                    ->getStateUsing(function ($record) {
                        return $record->quizzable->name ?? $record->quizzable->title ?? 'N/A';
                    }),
                ImageColumn::make('question_image'),
                TextColumn::make('marks')
                    ->sortable(),
                TextColumn::make('topic.name')
                    ->label('Topic')
                    ->searchable(),
                TextColumn::make('quiz.title')
                    ->label('Quiz')
                    ->searchable(),
                IconColumn::make('explanation')
                    ->boolean()
                    ->label('Has Explanation')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'mcq' => 'Multiple Choice',
                        'saq' => 'Short Answer',
                        'tf' => 'True/False',
                    ]),
                SelectFilter::make('quiz')
                    ->relationship('quiz', 'title'),
                SelectFilter::make('topic')
                    ->relationship('topic', 'name'),
                TernaryFilter::make('has_explanation')
                    ->label('Explanation')
                    ->boolean()
                    ->trueLabel('With explanation')
                    ->falseLabel('Without explanation')
                    ->nullable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('updated_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Add relations here if needed
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
