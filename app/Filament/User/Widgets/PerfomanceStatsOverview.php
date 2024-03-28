<?php

namespace App\Filament\User\Widgets;

use App\Models\User;
use App\Models\Course;
use App\Models\Subject;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\DB;
use App\Models\CompositeQuizSession;
use Illuminate\Support\Facades\Cache;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PerfomanceStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user(); // or any specific user ID
        // Check if the user is registered for a course
        if ($user->isRegisteredForCourse()) {
            // Fetch all courses' average scores for the user in one query
            $coursesScores = QuizAttempt::select('courses.title', DB::raw('AVG(quiz_attempts.score) as average_score'))
                ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
                ->join('courses', 'quizzes.quizzable_id', '=', 'courses.id')
                ->where('quizzes.quizzable_type', Course::class)
                ->where('quiz_attempts.user_id', $user->id)
                ->groupBy('courses.title')
                ->havingRaw('AVG(quiz_attempts.score) > 0') // Ensure there is a score
                ->get();

            // Determine the highest and lowest scoring courses
            $highestScoringCourse = $coursesScores->sortByDesc('average_score')->first();
            $lowestScoringCourse = $coursesScores->sortBy('average_score')->first();

            // Calculate the overall average score, considering caching
            $overallAverageScore = Cache::remember('overall_average_score', 3600, function () {
                return QuizAttempt::average('score') ?: 0;
            });

            // User's average score across all courses
            $userAverageScore = $coursesScores->avg('average_score') ?: 0;

            // Calculate the performance comparison as a percentage
            $performanceComparison = 0; // Default to 0
            if ($overallAverageScore > 0) {
                // Only perform the calculation if there are actual scores
                $performanceComparison = (($userAverageScore - $overallAverageScore) / $overallAverageScore) * 100;
            } else if ($userAverageScore > 0) {
                // If the user has a score, but there is no overall score, set to 100%
                $performanceComparison = 100;
            } else {
                // If there are no scores at all, it's not applicable or indeterminate
                $performanceComparison = null; // Indeterminate, can represent with "N/A"
            }

            return [
                Stat::make('Best Average Score', $highestScoringCourse ? round($highestScoringCourse->average_score) . ' points' : "N/A")
                    ->description($highestScoringCourse ? "Best in {$highestScoringCourse->name}" : "No data")
                    ->descriptionIcon('heroicon-o-chart-bar')
                    ->color('success'),

                Stat::make('Lowest Average Score', $lowestScoringCourse ? round($lowestScoringCourse->average_score) . ' points' : "N/A")
                    ->description($lowestScoringCourse ? "Needs work in {$lowestScoringCourse->name}" : "No data")
                    ->descriptionIcon('heroicon-o-chart-bar')
                    ->color('danger'),

                Stat::make('Performance Compared to Peers', is_null($performanceComparison) ? "N/A" : sprintf("%.2f%%", $performanceComparison))
                    ->description(is_null($performanceComparison) ? 'No data available' : ($performanceComparison > 0 ? 'Doing well 👍' : ($performanceComparison < 0 ? 'Can improve 👎' : 'Average')))
                    ->descriptionIcon(is_null($performanceComparison) ? 'heroicon-o-question-mark-circle' : ($performanceComparison >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down'))
                    ->color(is_null($performanceComparison) ? 'gray' : ($performanceComparison > 0 ? 'success' : ($performanceComparison < 0 ? 'danger' : 'warning'))),

               
            ];
        } else {
            $compositeQuizSessions = CompositeQuizSession::where('user_id', $user->id)->get();

            // Determine the highest score from all composite quiz sessions
            $highestCompositeScore = $compositeQuizSessions->max('total_score');

            // Fetch all subjects' average scores for the user in one query
            $subjectsScores = QuizAttempt::select('subjects.name', DB::raw('AVG(quiz_attempts.score) as average_score'))
            ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->join('subjects', 'quizzes.quizzable_id', '=', 'subjects.id')
            ->where('quizzes.quizzable_type', Subject::class)
            ->where('quiz_attempts.user_id', $user->id)
            ->groupBy('subjects.name')
            ->havingRaw('AVG(quiz_attempts.score) > 0') // Ensure there is a score
            ->get();

            // Determine the highest and lowest scoring subjects
            $highestScoringSubject = $subjectsScores->sortByDesc('average_score')->first();
            $lowestScoringSubject = $subjectsScores->sortBy('average_score')->first();

            // Calculate the overall average score, considering caching
            $overallAverageScore = Cache::remember('overall_average_score', 3600, function () {
                return QuizAttempt::average('score') ?: 0;
            });

            // User's average score across all subjects
            $userAverageScore = $subjectsScores->avg('average_score') ?: 0;

            // Calculate the performance comparison as a percentage
            // Calculate the performance comparison as a percentage
            $performanceComparison = 0; // Default to 0
            if ($overallAverageScore > 0) {
                // Only perform the calculation if there are actual scores
                $performanceComparison = (($userAverageScore - $overallAverageScore) / $overallAverageScore) * 100;
            } else if ($userAverageScore > 0) {
                // If the user has a score, but there is no overall score, set to 100%
                $performanceComparison = 100;
            } else {
                // If there are no scores at all, it's not applicable or indeterminate
                $performanceComparison = null; // Indeterminate, can represent with "N/A"
            }

            // dd($overallAverageScore);
            return [
                Stat::make('Best Average Score', $highestScoringSubject ? round($highestScoringSubject->average_score) . ' points' : "N/A")
                ->description($highestScoringSubject ? "Best in {$highestScoringSubject->name}" : "No data")
                    ->descriptionIcon('heroicon-o-chart-bar')
                    ->color('success'),

                Stat::make('Lowest Average Score', $lowestScoringSubject ? round($lowestScoringSubject->average_score) . ' points' : "N/A")
                ->description($lowestScoringSubject ? "Needs work in {$lowestScoringSubject->name}" : "No data")
                    ->descriptionIcon('heroicon-o-chart-bar')
                    ->color('danger'),

                Stat::make('Performance Compared to Peers', is_null($performanceComparison) ? "N/A" : sprintf("%.2f%%", $performanceComparison))
                    ->description(is_null($performanceComparison) ? 'No data available' : ($performanceComparison > 0 ? 'Doing well 👍' : ($performanceComparison < 0 ? 'Can improve 👎' : 'Average')))
                    ->descriptionIcon(is_null($performanceComparison) ? 'heroicon-o-question-mark-circle' : ($performanceComparison >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down'))
                    ->color(is_null($performanceComparison) ? 'gray' : ($performanceComparison > 0 ? 'success' : ($performanceComparison < 0 ? 'danger' : 'warning'))),

                Stat::make('Highest JAMB Test Score', $highestCompositeScore !== null ? "{$highestCompositeScore}" : "N/A")
                ->description($highestCompositeScore !== null ? 'Your top score across all attempts' : "No data")
                    ->descriptionIcon('heroicon-o-star')
                    ->color('success')
            ];
        }
        
    }
}
