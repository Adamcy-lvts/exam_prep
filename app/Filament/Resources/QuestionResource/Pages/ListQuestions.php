<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use Filament\Actions;
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
                    $subjectId = $data['course_id'];
                    $totalMarks = $data['total_marks'];

                    Excel::import(new QuestionImport($subjectId, $totalMarks), $file);



                    Notification::make()->title('Record Imported')->success()->send();

                    redirect()->route('filament.admin.resources.questions.index');
                })
                ->form([
                    Select::make('course_id')
                        ->required()
                        ->relationship('course', 'title'),
                    TextInput::make('total_marks')->numeric(),
                    FileUpload::make('attachment')->disk('xlsx')->directory('app'),
                ])
        ];
    }
}
