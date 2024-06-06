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

                    // Adjust the import class to handle the quizzable type and ID
                    // Excel::import(new QuestionImport($quizzableType, $quizzableId), $file);
                    $import = new QuestionImport($quizzableType, $quizzableId);
                    Excel::import($import, $file);

                    $filename = $data['attachment'];
                    $pathToFile = $filename;

                    if (Storage::disk('xlsx')->exists($pathToFile)) {
                        // Delete the file after processing
                        Storage::disk('xlsx')->delete($pathToFile);
                        Log::info("File deleted successfully: " . $pathToFile);
                    } else {
                        Log::error("Failed to delete the file: " . $pathToFile);
                    }

                    if ($data['question_image']) {
                        // Starting the process of handling the ZIP file containing question images.
                        $zipFile = $data['question_image'];

                        // Retrieve the full path of the uploaded ZIP file on the 'public' disk.

                        $zipFilePath = Storage::disk('public')->path($zipFile);

                        // Define a temporary directory for extracting images from the ZIP file.
                        $tempDirectory = 'temp_questions_images';
                        // Ensure that the temporary directory exists.
                        Storage::disk('public')->makeDirectory($tempDirectory);

                        // Create a new ZipArchive instance to work with the ZIP file.
                        $zip = new ZipArchive;

                        // Try to open the ZIP file.
                        if ($zip->open($zipFilePath) === TRUE) {
                            // If successful, extract the contents of the ZIP file to the temporary directory.
                            $zip->extractTo(storage_path('app/public/' . $tempDirectory));
                            // Close the ZIP file after extraction.
                            $zip->close();
                        } else {
                            // Log an error if the ZIP file cannot be opened.
                            Log::error("Failed to extract ZIP file: " . $zipFile);
                            return;
                        }

                        // Log the current state of the 'question-images' directory before processing.
                        Log::info("Before processing: " . json_encode(Storage::disk('public')->files('question-images')));

                        // Retrieve the list of files (images) in the temporary directory.
                        $files = Storage::disk('public')->files($tempDirectory);
                        $manager = new ImageManager(new Driver());
                        // Process each image from the temporary directory.
                        foreach ($files as $imagePath) {
                            // Extract the file extension and filename (without extension) from the image path.
                            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
                            $filename = basename($imagePath, '.' . $extension);

                            // Attempt to find a matching question record based on the image filename (assuming it's an phone).
                            $question = Question::where('question', $filename)->first();

                            // If a matching question is found...
                            if ($question) {
                                // Construct the new path for the question image.
                                $newImagePath = 'questions-images/question_image_' . $question->id . '.' . $extension;

                                Log::warning($newImagePath);
                                // create new manager instance

                                // Resize and crop the image using Intervention Image:
                                $img = $manager->read(storage_path('app/public/' . $imagePath));
                                $img->cover(300, 300);
                                $img->save(storage_path('app/public/' . $newImagePath));

                                // You don't need this line anymore. The image has already been saved in the right location.
                                // Storage::disk('public')->move($imagePath, $newImagePath);

                                // Update the question's profile_image attribute with the new image path and save the record.
                                $question->question_image = $newImagePath;
                                $question->save();
                            } else {
                                // If there's no matching question for the image, log a warning and delete the unassociated image.
                                Log::warning("No matching question for image: " . $imagePath);
                                Storage::disk('public')->delete($imagePath);
                            }
                        }

                        // Clean up: Delete the temporary directory used for extraction.
                        Storage::disk('public')->deleteDirectory($tempDirectory);
                        // Delete the original ZIP file.
                        Storage::disk('public')->delete($zipFile);
                    }
                if (!empty($import->getErrors())) {
                    Notification::make()
                    ->title('Duplicate Questions Found')
                    ->warning()
                    ->send();
                } else {
                    Notification::make()->title('Record Imported')->success()->send();
                }

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
                    FileUpload::make('attachment')->label('Questions File')->required()->preserveFilenames()->disk('xlsx')->directory('excel'),
                    FileUpload::make('question_image')->label('Questions Images'),
                    // FileUpload::make('attachment')->disk('xlsx')->directory('app'),
                ])

        ];
    }
}
