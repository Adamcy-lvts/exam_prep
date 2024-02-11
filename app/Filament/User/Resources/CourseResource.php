<?php

namespace App\Filament\User\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\User\Resources\CourseResource\Pages;
use App\Filament\User\Resources\CourseResource\RelationManagers;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getNavigationLabel(): string
    {
        return 'Registered Courses';
    }

    public static function getNavigationBadge(): ?string
    {
        return auth()->user()->subjects->count();
    }

    // public static function canView(): bool
    // {
    //     // Only allow users who have registered courses to view this resource in the navigation.
    //     return auth()->check() && auth()->user()->courses->count() > 0;
    // }
    // protected static function authorize(): bool
    // {
    //     // Only allow users who have registered courses to view this resource in the navigation.
    //     return auth()->check() && auth()->user()->courses->count() > 0;
    // }

    // public static function canViewAny(): bool
    // {
    //     // Only show the navigation item if the user has registered courses.
    //     return auth()->check() && auth()->user()->courses()->exists();
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('course_code'),

            ])->modifyQueryUsing(function (Builder $query) {
                // Only apply this modification if a user is authenticated
                if (Auth::check()) {
                    // Get the course IDs that the user is registered for
                    $userCourseIds = Auth::user()->courses()->pluck('courses.id')->toArray();

                    // Apply the constraint to the query
                    $query->whereIn('id', $userCourseIds);
                    // dd($query->toSql(),$userCourseIds);
                    // dd($query->whereIn('id', $userCourseIds));
                }

            })
            ->filters([
                //
            ])
            ->actions([Action::make('delete')
                ->requiresConfirmation()
                ->action(function ($record) {
                    // Assuming the authenticated user is the one whose relationship you want to delete
                    $user = Auth::user();
                    $user->courses()->detach($record->id);
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
            'index' => Pages\ListCourses::route('/'),
            // 'create' => Pages\CreateCourse::route('/create'),
            'pricing-page' => Pages\PricingPage::route('/pricing'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
            'instruction-page' => Pages\InstructionPage::route('/{record}/{quizzableType}/instructions'),
            'questions' => Pages\Questions::route('/{record}/{quizzableType}/questions'),
            'result' => Pages\ResultPage::route('/{attemptId}/{quizzableId}/{quizzableType}/result'),
        ];
    }
}
