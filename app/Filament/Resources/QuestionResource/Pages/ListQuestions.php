<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use ZipArchive;
use Filament\Actions;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Question;
use Filament\Actions\Action;
use App\Imports\QuestionImport;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\QuestionResource;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Drivers\Imagick\Driver;

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
                    $imageFiles = $data['question_images'] ?? [];
                    $originalFilenames = $data['original_filenames'] ?? [];

                    $import = new QuestionImport($quizzableType, $quizzableId, $imageFiles, $originalFilenames);
                    Excel::import($import, $file);

                    $this->deleteUploadFile($data['attachment']);

                    $this->displayImportNotification($import);

                    redirect()->route('filament.admin.resources.questions.index');
                })
                ->form([
                    Select::make('quizzable_type')
                        ->options([
                            'course' => 'Course',
                            'subject' => 'Subject',
                        ])
                        ->reactive()
                        ->required(),
                    Select::make('quizzable_id')
                        ->options(function (callable $get) {
                            $quizzableType = $get('quizzable_type');
                            if ($quizzableType === 'course') {
                                return Course::all()->mapWithKeys(function ($course) {
                                    return [$course->id => $course->title . ' (' . $course->course_code . ')'];
                                });
                            } else {
                                return Subject::all()->pluck('name', 'id');
                            }
                        })
                        ->required(),
                    FileUpload::make('attachment')
                        ->label('Questions File (Excel)')
                        ->required()
                        ->preserveFilenames()
                        ->disk('xlsx')
                        ->directory('excel')
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                    FileUpload::make('question_images')
                        ->label('Question Images')
                        ->directory('temp_questions_images')
                        ->preserveFilenames()
                        ->storeFileNamesIn('original_filenames')
                        ->multiple()
                        ->maxSize(5120) // 5MB
                        // ->acceptedFileTypes(['image/*', 'application/zip'])
                        ->downloadable()
                        ->openable()
                ])
        ];
    }

    private function deleteUploadFile($filename)
    {
        $pathToFile = $filename;
        if (Storage::disk('xlsx')->exists($pathToFile)) {
            Storage::disk('xlsx')->delete($pathToFile);
            Log::info("File deleted successfully: " . $pathToFile);
        } else {
            Log::error("Failed to delete the file: " . $pathToFile);
        }
    }

    // private function processQuestionImages($images)
    // {
    //     foreach ($images as $image) {
    //         $extension = pathinfo($image, PATHINFO_EXTENSION);

    //         if (strtolower($extension) === 'zip') {
    //             $this->processZipFile($image);
    //         } else {
    //             Log::info("Heloo");
    //             $this->processSingleImage($image);
    //         }
    //     }
    // }

    // private function processZipFile($zipFile)
    // {
    //     $zipFilePath = Storage::disk('public')->path($zipFile);
    //     $tempDirectory = 'temp_questions_images';
    //     Storage::disk('public')->makeDirectory($tempDirectory);

    //     $zip = new ZipArchive;
    //     if ($zip->open($zipFilePath) === TRUE) {
    //         $zip->extractTo(storage_path('app/public/' . $tempDirectory));
    //         $zip->close();

    //         $files = Storage::disk('public')->files($tempDirectory);
    //         foreach ($files as $file) {
    //             $this->processSingleImage($file);
    //         }

    //         Storage::disk('public')->deleteDirectory($tempDirectory);
    //     } else {
    //         Log::error("Failed to extract ZIP file: " . $zipFile);
    //     }

    //     Storage::disk('public')->delete($zipFile);
    // }

    // private function processSingleImage($imagePath)
    // {
    //     Log::info("we are here");
    //     $filename = pathinfo($imagePath, PATHINFO_FILENAME);
    //     $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

    //     // Try to find a question with a matching filename or question text
    //     $question = Question::where('question_image', 'LIKE', "%$filename%")
    //         ->orWhere('question', 'LIKE', "%$filename%")
    //         ->first();

    //     if ($question) {
    //         $newImagePath = 'questions-images/question_image_' . $question->id . '_' . time() . '.' . $extension;

    //         $img = Image::make(storage_path('app/public/' . $imagePath));
    //         $img->fit(800, 600, function ($constraint) {
    //             $constraint->aspectRatio();
    //             $constraint->upsize();
    //         });
    //         $img->save(storage_path('app/public/' . $newImagePath));

    //         // Update the question_image field in the database
    //         $question->question_image = $newImagePath;
    //         $question->save();

    //         Storage::disk('public')->delete($imagePath);

    //         Log::info("Image processed and saved for question ID {$question->id}: {$newImagePath}");
    //     } else {
    //         Log::warning("No matching question for image: " . $imagePath);
    //     }
    // }
    private function displayImportNotification($import)
    {
        if (!empty($import->getErrors())) {
            \Filament\Notifications\Notification::make()
                ->title('Some questions were updated')
                ->warning()
                ->send();
        } else {
            \Filament\Notifications\Notification::make()
                ->title('Questions Imported Successfully')
                ->body($import->getNewEntriesCount() . ' new questions added.')
                ->success()
                ->send();
        }
    }
}
