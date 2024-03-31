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
           
        } else {
            
        }
        
    }
}
