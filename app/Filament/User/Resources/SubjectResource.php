<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\SubjectResource\Pages;
use App\Filament\User\Resources\SubjectResource\RelationManagers;

class SubjectResource extends Resource
{
    protected static ?string $model = Subject::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getNavigationLabel(): string
    {
        return 'Registered Subjects';
    }

    public static function getNavigationBadge(): ?string
    {
        return auth()->user()->subjects->count();
    }

    // public static function canViewAny(): bool
    // {
    //     // Only show the navigation item if the user has registered courses.
    //     return auth()->check() && auth()->user()->subjects()->exists();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])->modifyQueryUsing(function (Builder $query) {
                // Only apply this modification if a user is authenticated
                if (Auth::check()) {
                    // Get the course IDs that the user is registered for
                    $userCourseIds = Auth::user()->subjects()->pluck('subjects.id')->toArray();

                    // Apply the constraint to the query
                    $query->whereIn('id', $userCourseIds);
                    // dd($query->toSql(),$userCourseIds);
                    // dd($query->whereIn('id', $userCourseIds));
                }
            })
            ->filters([
                //
            ])
            ->actions([
                Action::make('delete')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        // Assuming the authenticated user is the one whose relationship you want to delete
                        $user = Auth::user();
                        $user->subjects()->detach($record->id);
                    })
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
            'index' => Pages\ListSubjects::route('/'),
            // 'create' => Pages\CreateSubject::route('/create'),
            'jamb-instrcution' => Pages\JambInstructionPage::route('jamb/instruction-page'),
            'pricing-page' => Pages\PricingPage::route('/pricing'),
            'edit' => Pages\EditSubject::route('/{record}/edit'),
            'instruction-page' => Pages\InstructionPage::route('/{record}/{quizzableType}/instructions'),
            'questions' => Pages\Questions::route('/{record}/{quizzableType}/questions'),
            'result' => Pages\ResultPage::route('/{attemptId}/{quizzableId}/{quizzableType}/result'),
            'jamb-quiz' => Pages\JambQuizPage::route('/{compositeSessionId}/jamb/quiz'),
            'jamb-quiz-result' => Pages\JambQuizResult::route('/{compositeSessionId}/jamb-quiz/result'),
            'payment-form' => Pages\PaymentForm::route('/{planId}/payment'),
            'lessons' => Pages\SubjectLessonPage::route('/{subjectId}/lessons'),
            'view-receipt' => Pages\ViewReceipt::route('/{record}/view-receipt'),
            
        ];
    }
}
