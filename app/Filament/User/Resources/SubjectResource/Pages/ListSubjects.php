<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use Filament\Actions;
use App\Models\Subject;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\User\Resources\SubjectResource;

class ListSubjects extends ListRecords
{
    protected static string $view = 'filament.user.pages.subjects';

    protected static string $resource = SubjectResource::class;

    public $subjects;
    public $user;

    public function mount(): void

    {
        $this->subjects = Auth::user()->subjects;

        $this->user = auth()->user();
    }


    public function getTitle(): string | Htmlable
    {
        return __('Registered Subjects');
    }

    // protected function getHeaderActions(): array
    // {
    //     return [


    //         Action::make('Register Subjects')
    //         ->form([
    //             Select::make('course_ids')
    //             ->label('Subjects')
    //             ->multiple()
    //                 ->options(Subject::query()->pluck('name', 'id'))
    //                 ->required(),
    //         ])
    //             ->action(function (array $data): void {
    //             logger()->info('Register Subjects Action Called', $data);
    //                 // Use the authenticated user instance directly
    //                 $user = auth()->user();

    //                 // Perform the action only if there is an authenticated user
    //                 if ($user) {
    //                     $subjectIds = $data['course_ids'];
    //                     $user->subjects()->syncWithoutDetaching($subjectIds);
    //                 }
    //             })
    //     ];
    // }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Register Subjects')
            ->form([
                Select::make('course_ids')
                ->label('Subjects')
                ->multiple()
                ->options(
                    Subject::query()
                    ->with('exam') // Eager load the related exam
                        ->get()
                        ->pluck('full_name', 'id') // Use a custom attribute for the full name
                )
                ->required(),
            ])
            ->action(function (array $data): void {
                logger()->info('Register Subjects Action Called', $data);
                // Use the authenticated user instance directly
                $user = auth()->user();

                // Perform the action only if there is an authenticated user
                if ($user) {
                    $subjectIds = $data['course_ids'];
                    $user->subjects()->syncWithoutDetaching($subjectIds);
                }
            }),
            Action::make('Take Jamb Test')
                ->url(route('filament.user.resources.subjects.jamb-instrcution')),
          
        
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
