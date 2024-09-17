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
                    // Extract form data
                    $file = $data['attachment'];
                    $quizzableType = $data['quizzable_type'];
                    $quizzableId = $data['quizzable_id'];

                    // Create an instance of QuestionImport and import the Excel file
                    $import = new QuestionImport($quizzableType, $quizzableId);
                    Excel::import($import, $file);

                    // Delete the uploaded Excel file after processing
                    $this->deleteUploadFile($data['attachment']);

                    // Process question images if provided
                    if ($data['question_image']) {
                        $this->processQuestionImages($data['question_image']);
                    }

                    // Display appropriate notification based on import results
                    $this->displayImportNotification($import);

                    // Redirect to the questions index page
                    redirect()->route('filament.admin.resources.questions.index');
                })
                ->form([
                    // Form fields for the import action
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
                            return $quizzableType === 'course'
                                ? Course::all()->pluck('title', 'id')
                                : Subject::all()->pluck('name', 'id');
                        })
                        ->required(),
                    FileUpload::make('attachment')
                        ->label('Questions File')
                        ->required()
                        ->preserveFilenames()
                        ->disk('xlsx')
                        ->directory('excel'),
                    FileUpload::make('question_image')
                        ->label('Questions Images')
                        ->disk('public')
                        ->directory('temp_questions_images'),
                ])


        ];
    }

    /**
     * Delete the uploaded Excel file after processing
     *
     * @param string $filename
     */
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

    /**
     * Process uploaded question images
     *
     * @param string $zipFile
     */
    private function processQuestionImages($zipFile)
    {
        // Retrieve the full path of the uploaded ZIP file
        $zipFilePath = Storage::disk('public')->path($zipFile);

        // Define a temporary directory for extracting images
        $tempDirectory = 'temp_questions_images';
        Storage::disk('public')->makeDirectory($tempDirectory);

        // Extract ZIP file contents
        $zip = new ZipArchive;
        if ($zip->open($zipFilePath) === TRUE) {
            $zip->extractTo(storage_path('app/public/' . $tempDirectory));
            $zip->close();
        } else {
            Log::error("Failed to extract ZIP file: " . $zipFile);
            return;
        }

        // Process extracted images
        $files = Storage::disk('public')->files($tempDirectory);
        $manager = new ImageManager(new Driver());
        foreach ($files as $imagePath) {
            $this->processIndividualImage($imagePath, $manager);
        }

        // Clean up: Delete temporary directory and ZIP file
        Storage::disk('public')->deleteDirectory($tempDirectory);
        Storage::disk('public')->delete($zipFile);
    }

    /**
     * Process an individual image file
     *
     * @param string $imagePath
     * @param ImageManager $manager
     */
    private function processIndividualImage($imagePath, $manager)
    {
        $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
        $filename = basename($imagePath, '.' . $extension);

        // Find matching question
        $question = Question::where('question', $filename)->first();

        if ($question) {
            $newImagePath = 'questions-images/question_image_' . $question->id . '.' . $extension;

            // Resize and crop the image
            $img = $manager->read(storage_path('app/public/' . $imagePath));
            $img->cover(300, 300);
            $img->save(storage_path('app/public/' . $newImagePath));

            // Update question with new image path
            $question->question_image = $newImagePath;
            $question->save();
        } else {
            Log::warning("No matching question for image: " . $imagePath);
            Storage::disk('public')->delete($imagePath);
        }
    }

    /**
     * Display appropriate notification based on import results
     *
     * @param QuestionImport $import
     */
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
