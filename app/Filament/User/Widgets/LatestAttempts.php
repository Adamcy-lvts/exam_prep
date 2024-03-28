<?php

namespace App\Filament\User\Widgets;

use App\Models\Quiz;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\QuizAttempt;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LatestAttempts extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => auth()->user()->QuizAttempts())
            ->inverseRelationship('user')
            ->columns([
                TextColumn::make('user.full_name')
                    ->label('Full Name'),
                TextColumn::make('quiz.title')->label('Quiz Title'),
                TextColumn::make('score')->label('Score'),
                TextColumn::make('created_at')->label('Attempted On')->dateTime('Y-m-d H:i:s A'),

            ])->filters([
                // ...
            ])
             ->actions([
                Action::make('View Attempt')
                    ->label('View Attempt')
                    ->url(function (QuizAttempt $record) {
                        // dd($record);
                        $user = auth()->user();
                        $latestAttempt = $record;
                        $quiz = Quiz::find($latestAttempt->quiz_id);

                        if ($user->can('view_subject') || $user->can('view_any_subject')) {
                            return route('filament.user.resources.subjects.result', [
                                'attemptId' => $latestAttempt->id,
                                'quizzableId' => $quiz->quizzable_id,
                                'quizzableType' => $quiz->quizzable_type,
                            ]);
                        } elseif ($user->can('view_course') || $user->can('view_any_course')) {
                            return route('filament.user.resources.courses.result', [
                                'attemptId' => $latestAttempt->id,
                                'quizzableId' => $quiz->quizzable_id,
                                'quizzableType' => $quiz->quizzable_type,
                            ]);
                        }
                    })
      
            ]);

        }
}
