<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Plan;
use App\Models\User;
use Filament\Actions;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\CourseResource;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ListCourses extends ListRecords
{
    protected static string $view = 'filament.user.pages.courses';

    protected static string $resource = CourseResource::class;

    public $courses;
    public $user;

    public function mount(): void

    {
        $this->courses = Auth::user()->courses;

        $this->user = auth()->user();
    }


    public function getTitle(): string | Htmlable
    {
        return __('Registered Courses');
    }

    protected function getHeaderActions(): array
    {
        return [


            Action::make('addCourses')
                ->form([
                    Select::make('course_ids')
                        ->label('Courses')
                        ->multiple()
                        ->options(Course::query()->pluck('title', 'id'))
                        ->required(),

                        
                ])
                ->action(function (array $data): void {
                    // Use the authenticated user instance directly
                    $user = auth()->user();

                    // Perform the action only if there is an authenticated user
                    if ($user) {
                        $courseIds = $data['course_ids'];
                        $user->courses()->syncWithoutDetaching($courseIds);
                    }

                    $basicPlan = Plan::where('title', 'Basic Access Plan')->first();

                    foreach ($this->user->courses as $course) {
                        $this->user->courseAttempts()->create([
                            'course_id' => $course->id,
                            'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                        ]);
                    }
                })
        ];
    }

    protected function getActions(): array
    {
        return [
            Action::make('settings')->action('openSettingsModal'),
        ];
    }

    public function openSettingsModal(): void
    {
        $this->dispatchBrowserEvent('open-settings-modal');
    }
}
