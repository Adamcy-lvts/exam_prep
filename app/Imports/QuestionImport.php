<?php

namespace App\Imports;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Module;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToCollection, WithHeadingRow
{
    protected $quizzable;
    protected $quizId;
    public $errors = [];
    private $newEntriesCount = 0;
    private $imageFiles;
    private $originalFilenames;

    public function __construct($quizzableType, $quizzableId, $imageFiles, $originalFilenames)
    {
        $this->quizzable = $quizzableType == 'course'
            ? Course::findOrFail($quizzableId)
            : Subject::findOrFail($quizzableId);
        $this->imageFiles = $imageFiles;
        $this->originalFilenames = $originalFilenames;
    }

    public function collection(Collection $rows)
    {
        $quiz = $this->createOrUpdateQuiz($rows);

        foreach ($rows as $row) {
            $this->processQuestion($row, $quiz);
        }

        $this->processQuestionImages();
    }

    protected function createOrUpdateQuiz($rows)
    {
        $totalMarks = $rows->sum('mark');
        $totalQuestions = $rows->count();

        return Quiz::updateOrCreate(
            [
                'quizzable_type' => get_class($this->quizzable),
                'quizzable_id' => $this->quizzable->id,
            ],
            [
                'title' => $this->quizzable->name ?? $this->quizzable->title,
                'total_marks' => $totalMarks,
                'duration' => 60, // Default value, adjust as needed
                'total_questions' => $totalQuestions,
                'max_attempts' => 3, // Default value, adjust as needed
            ]
        );
    }

    protected function processQuestion($row, $quiz)
    {
        $moduleUnitTopic = $this->findOrCreateModuleUnitTopic($row);

        $questionData = [
            'marks' => $row['mark'],
            'quizzable_id' => $this->quizzable->id,
            'quizzable_type' => get_class($this->quizzable),
            'type' => strtolower($row['type']),
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
            'explanation' => $row['explanation'] ?? null,
            'quiz_id' => $quiz->id,
        ];

        // Handle the image filename
        if (isset($row['image_filename']) && !empty($row['image_filename'])) {
            $questionData['question_image'] = $row['image_filename'];
        }

        $question = Question::updateOrCreate(
            ['question' => $row['question']],
            $questionData
        );

        if ($question->wasRecentlyCreated) {
            $this->newEntriesCount++;
            $this->handleOptions($question, $row);
        } else {
            $this->errors[] = "Question updated (not newly created): " . $row['question'];
        }

        Log::info("Question " . ($question->wasRecentlyCreated ? "created" : "updated") . " with ID {$question->id}. Image filename: " . ($questionData['question_image'] ?? 'Not provided'));
    }

    protected function handleOptions($question, $row)
    {
        if ($question->type === 'mcq') {
            $optionColumns = ['option_a', 'option_b', 'option_c', 'option_d'];
            $correctAnswer = strtolower(trim($row['is_correct']));

            foreach ($optionColumns as $index => $column) {
                if (isset($row[$column]) && $row[$column] !== null) {
                    $optionText = strtolower(trim($row[$column]));
                    $isCorrect = false;

                    // Check if correct answer is a letter (A, B, C, D)
                    if (in_array($correctAnswer, ['a', 'b', 'c', 'd'])) {
                        $isCorrect = $correctAnswer === chr(97 + $index); // a, b, c, d
                    }
                    // Check if correct answer matches the option text
                    else {
                        $isCorrect = $optionText === $correctAnswer;
                    }

                    $question->options()->create([
                        'option' => $row[$column],
                        'is_correct' => $isCorrect,
                    ]);
                }
            }
        } elseif ($question->type === 'saq' || $question->type === 'tf') {
            // For both SAQ and TF, use the 'answer_text' column
            $question->answer_text = $row['answer_text'];
            $question->save();
        }
    }

    protected function findOrCreateModuleUnitTopic($row)
    {
        $moduleName = $row['module'] ?? null;
        $unitName = $row['unit'] ?? null;
        $topicName = $row['topic'] ?? null;

        $module = $unit = $topic = null;

        // Create or find module
        if ($moduleName) {
            $module = Module::firstOrCreate(['name' => $moduleName]);
        }

        // Create or find unit
        if ($module && $unitName) {
            $unit = $module->units()->firstOrCreate(['name' => $unitName]);
        }

        // Create or find topic
        if ($topicName) {
            $topic = Topic::firstOrCreate(
                [
                    'name' => $topicName,
                    'topicable_id' => $this->quizzable->id,
                    'topicable_type' => get_class($this->quizzable)
                ],
                ['unit_id' => $unit ? $unit->id : null]
            );
        }

        return ['module' => $module, 'unit' => $unit, 'topic' => $topic];
    }

    private function processQuestionImages()
    {
        foreach ($this->imageFiles as $imagePath) {
            $this->processSingleImage($imagePath);
        }
    }

    private function processSingleImage($imagePath)
    {
        Log::info("Processing image: " . $imagePath);
        $originalFilename = $this->getOriginalFilename($imagePath);
        $filenameWithoutExtension = pathinfo($originalFilename, PATHINFO_FILENAME);

        $question = Question::where('question_image', 'LIKE', $filenameWithoutExtension . '%')
            ->orWhere('question', 'LIKE', $filenameWithoutExtension . '%')
            ->first();

        if ($question) {
            $newImagePath = 'questions-images/' . $originalFilename;

            Log::info("Question found. New image path: " . $newImagePath);

            // Move the file instead of processing it with Intervention Image
            if (Storage::disk('public')->move($imagePath, $newImagePath)) {
                $question->question_image = $newImagePath;
                $question->save();

                Log::info("Question updated with new image path: " . $newImagePath);
            } else {
                Log::error("Failed to move image: " . $imagePath);
            }
        } else {
            Log::warning("No matching question for image: " . $originalFilename);
        }
    }

    private function getOriginalFilename($uploadedFilename)
    {
        return $this->originalFilenames[$uploadedFilename] ?? $uploadedFilename;
    }

    public function getNewEntriesCount()
    {
        return $this->newEntriesCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
