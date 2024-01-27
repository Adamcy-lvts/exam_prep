<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use App\Models\TopicPerformance;
use Filament\Resources\Pages\Page;
use App\Filament\Traits\ResultPageTrait;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\CourseResource;

class ResultPage extends Page
{
    use ResultPageTrait;
    
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.result-page';

    

    
}
