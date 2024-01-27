<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use Filament\Actions;
use App\Models\Course;
use App\Models\Subject;
use Filament\Actions\Action;
use App\Imports\QuestionImport;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\QuestionResource;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Import')
                ->action(function (array $data): void {
                    $file = $data['attachment'];
                    $quizzableType = $data['quizzable_type'];
                    $quizzableId = $data['quizzable_id'];
                    $totalMarks = $data['total_marks'];

                    // Adjust the import class to handle the quizzable type and ID
                    Excel::import(new QuestionImport($quizzableType, $quizzableId, $totalMarks), $file);

                    Notification::make()->title('Record Imported')->success()->send();

                    redirect()->route('filament.admin.resources.questions.index');
                })
                ->form([
                    Select::make('quizzable_type')
                        ->options([
                            'course' => 'Course',
                            'subject' => 'Subject',
                        ])
                        ->reactive() // Make this field reactive
                        ->required(),
                    Select::make('quizzable_id')
                        ->options(function (callable $get) {
                            $quizzableType = $get('quizzable_type');
                            if ($quizzableType === 'course') {
                                return Course::all()->pluck('title', 'id');
                            } elseif ($quizzableType === 'subject') {
                                return Subject::all()->pluck('name', 'id');
                            }
                            return [];
                        })
                        ->required(),
                    TextInput::make('total_marks')->numeric(),
                    FileUpload::make('attachment')->disk('xlsx')->directory('app'),
                ])

        ];
    }
}
