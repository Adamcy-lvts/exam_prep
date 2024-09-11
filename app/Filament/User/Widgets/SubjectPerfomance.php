<?php

namespace App\Filament\User\Widgets;

use App\Models\Subject;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\DB;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class SubjectPerfomance extends BaseWidget
{
    protected static ?int $sort = -2;

    public static function canView(): bool
    {
        return Auth::user()->can('view_subject') || Auth::user()->can('view_any_subject');
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // JAMB-like composite sessions
        $compositeQuizSessions = CompositeQuizSession::where('user_id', $user->id)->get();
        $highestCompositeScore = $compositeQuizSessions->max('total_score');

        // Individual subject attempts
        $subjectsScores = QuizAttempt::select('subjects.name', 'quiz_attempts.score', 'quiz_attempts.created_at')
            ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->join('subjects', 'quizzes.quizzable_id', '=', 'subjects.id')
            ->where('quizzes.quizzable_type', Subject::class)
            ->where('quiz_attempts.user_id', $user->id)
            ->whereIn(DB::raw('(quizzes.quizzable_id, quiz_attempts.created_at)'), function ($query) use ($user) {
                $query->select('quizzes.quizzable_id', DB::raw('MAX(quiz_attempts.created_at)'))
                    ->from('quiz_attempts')
                    ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
                    ->where('quizzes.quizzable_type', Subject::class)
                    ->where('quiz_attempts.user_id', $user->id)
                    ->groupBy('quizzes.quizzable_id');
            })
            ->get();

        $highestScoringSubject = $subjectsScores->sortByDesc('score')->first();
        $lowestScoringSubject = $subjectsScores->sortBy('score')->first();

        $userAverageScore = $subjectsScores->avg('score') ?: 0;

        return [
            Stat::make('Best Subject Score', $highestScoringSubject ?
                round($highestScoringSubject->score, 2) . ' points' : "N/A")
                ->description($highestScoringSubject ? "Best in {$highestScoringSubject->name}" : "No data")
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('success'),

            Stat::make('Lowest Recent Subject Score', $lowestScoringSubject ?
                round($lowestScoringSubject->score, 2) . ' points' : "N/A")
                ->description($lowestScoringSubject ? "Recent low in {$lowestScoringSubject->name}" : "No data")
                ->descriptionIcon('heroicon-o-chart-bar')
                ->color('danger'),

            Stat::make(
                'Average Recent Subject Score',
                round($userAverageScore, 2) . ' points'
            )
                ->description('Your average across recent subject attempts')
                ->descriptionIcon('heroicon-o-academic-cap')
                ->color('primary'),

            Stat::make('Highest JAMB Test Score', $highestCompositeScore !== null ?
                "{$highestCompositeScore}" : "N/A")
                ->description($highestCompositeScore !== null ? 'Your top score across all attempts' : "No data")
                ->descriptionIcon('heroicon-o-star')
                ->color('success')
        ];
    }
}
