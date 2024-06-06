<?php

namespace App\Imports;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Module;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection
{
    protected $courseId;
    protected $totalMarks;
    public $correctAnswerColumnIndex;
    public $lastColumnIndex;
    public $isCorrectColumn;
    public $quizzableId;
    public $quizzableType;
    protected $typeColumnIndex = 7;
    protected $shortAnswerColumnIndex = 8;
    public $quizId;
    public $quizzable;
    public $errors;
    private $newEntriesCount = 0;  // Initialize the counter



    public function __construct($quizzableType, $quizzableId)
    {
        if ($quizzableType == 'course') {
            $this->quizzable = Course::with('questions')->findOrFail($quizzableId);
        } elseif ($quizzableType == 'subject') {
            $this->quizzable = Subject::with('questions')->findOrFail($quizzableId);
        } else {
            throw new \Exception("Invalid quizzable type provided");
        }

        $this->quizzableType = $quizzableType;
        $this->quizzableId = $quizzableId;
        // $this->totalMarks = $totalMarks;
    }

    public function collection(Collection $rows)
    {
        // dd('Working...');
        // Skip the first row as it contains the headers
        $headers = $rows->shift();

        // Get the last column index
        $this->lastColumnIndex = $headers->count() - 1;

        // Check if the last column header is "Is_Correct"
        $correctAnswerColumnHeader = $headers->last();
        $this->isCorrectColumn = false;
        if ($correctAnswerColumnHeader === "Is_Correct") {
            $this->correctAnswerColumnIndex = $this->lastColumnIndex;
            $this->isCorrectColumn = true;
        } else {
            $this->correctAnswerColumnIndex = $this->lastColumnIndex + 1;
        }


        // Initialize total marks
        $totalMarks = 0;

        // Iterate over the rows to calculate total marks
        foreach ($rows as $row) {
            $totalMarks += $row[1]; // Assuming marks are in the second column (index 1)
        }

        // Create or find a quiz
        $quiz = Quiz::firstOrCreate([
            'title' => $this->quizzable->name ?? $this->quizzable->title . ' ' . $this->quizzable->course_code,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'quizzable_id' => $this->quizzableId,
            'total_marks' => $totalMarks, // Use the calculated total marks
            'duration' => 60, // Example default value
            'total_questions' => count($rows), // Count the number of questions
            'max_attempts' => 3, // Example default value
        ]);

        // Store quiz_id for later use
        $this->quizId = $quiz->id;

        foreach ($rows as $row) {
            if ($row[7] === 'mcq') {
                $this->importMultipleChoiceQuestion($row);
            } elseif ($row[7] === 'saq') {
                $this->importShortAnswerQuestion($row);
            } elseif ($row[7] === 'tf') {
                $this->importTrueOrFalseQuestion($row);
            }
        }
    }

    protected function importMultipleChoiceQuestion($row)
    {
        // Extract module, unit, and topic from the row
        $moduleUnitTopic = $this->findOrCreateModuleUnitTopic($row);

        // Check if the question already exists to avoid duplicates
        $existingQuestion = Question::where([
            'question' => $row[0],
            'quiz_id' => $this->quizId,
        ])->exists();

        if ($existingQuestion) {
            $this->errors[] = "Skipped existing question: " . $row[0];
            return; // Skip this question
        }

        // Since the question does not exist, create a new one
        $question = Question::create([
            'question' => $row[0],
            'marks' => $row[1],
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'quiz_id' => $this->quizId,
            'type' => $row[7],
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
            'explanation' => $row[12] ? $row[12] : null
        ]);

        // Use firstOrCreate to handle duplicates and new entries efficiently
        // $question = Question::firstOrCreate(
        //     [
        //         'question' => $row[0],  // Check if the question text already exists for this quiz
        //         'quiz_id' => $this->quizId,
        //         'type' => $row[7],
        //     ],
        //     [
        //         'marks' => $row[1],
        //         'quizzable_id' => $this->quizzableId,
        //         'quizzable_type' => $this->quizzable->getMorphClass(),

        //         'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        //         'explanation' => $row[12] ? $row[12] : null
        //     ]
        // );

        // Only process options if the question was newly created
        if ($question->wasRecentlyCreated) {
            $this->handleOptions($question, $row);
            $this->newEntriesCount++;  // Increment if new question was added
        } else {
            $this->errors[] = "A question with the same text already exists and was not imported: " . $row[0];
        }
    }

    protected function handleOptions($question, $row)
    {
        $correctOptionContent = $row[6];  // Get the correct option's content

        // Loop through options (Columns C through F)
        for ($i = 2; $i <= 5; $i++) {
            $optionValue = $row[$i];
            $isCorrect = ($correctOptionContent === $optionValue) ? 1 : 0;  // Determine if this option is correct

            // Store the option
            $question->options()->create([
                'option' => $optionValue,
                'is_correct' => $isCorrect,
            ]);
        }
    }


    protected function importTrueOrFalseQuestion($row)
    {
        $moduleUnitTopic = $this->findOrCreateModuleUnitTopic($row);

        // Check if the question already exists to avoid duplicates
        $existingQuestion = Question::where([
            'question' => $row[0],
            'quiz_id' => $this->quizId,
        ])->exists();

        if ($existingQuestion) {
            $this->errors[] = "Skipped existing question: " . $row[0];
            return; // Skip this question
        }

        // Since the question does not exist, create a new one
        $question = Question::create([
            'question' => $row[0],
            'marks' => $row[1],
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'quiz_id' => $this->quizId,
            'type' => $row[7],
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
            'explanation' => $row[12] ? $row[12] : null
        ]);

        // $question = Question::firstOrCreate(
        //     [
        //         'question' => $row[0], // Criteria to check existence
        //         'quiz_id' => $this->quizId,
        //         'type' => $row[7],
        //     ],
        //     [
        //         'quizzable_id' => $this->quizzableId,
        //         'quizzable_type' => $this->quizzable->getMorphClass(),

        //         'answer_text' => $row[8], // Store the correct answer
        //         'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        //         'explanation' => $row[12] ? $row[12] : null
        //     ]
        // );

        if ($question->wasRecentlyCreated) {
            $this->newEntriesCount++;
        } else {
            $this->errors[] = "A question with the same text already exists and was not imported: " . $row[0];
        }
    }


    protected function importShortAnswerQuestion($row)
    {
        $moduleUnitTopic = $this->findOrCreateModuleUnitTopic($row);

        // Check if the question already exists to avoid duplicates
        $existingQuestion = Question::where([
            'question' => $row[0],
            'quiz_id' => $this->quizId,
        ])->exists();

        if ($existingQuestion) {
            $this->errors[] = "Skipped existing question: " . $row[0];
            return; // Skip this question
        }

        // Since the question does not exist, create a new one
        $question = Question::create([
            'question' => $row[0],
            'marks' => $row[1],
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'quiz_id' => $this->quizId,
            'type' => $row[7],
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
            'explanation' => $row[12] ? $row[12] : null
        ]);

        // $question = Question::firstOrCreate(
        //     [
        //         'question' => $row[0], // Criteria to check existence
        //         'quiz_id' => $this->quizId,
        //         'type' => $row[7],
        //     ],
        //     [
        //         'marks' => $row[1],
        //         'quizzable_id' => $this->quizzableId,
        //         'quizzable_type' => $this->quizzable->getMorphClass(),

        //         'answer_text' => $row[8], // Store the correct answer
        //         'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        //         'explanation' => $row[12] ? $row[12] : null
        //     ]
        // );

        if ($question->wasRecentlyCreated) {
            $this->newEntriesCount++;
        } else {
            $this->errors[] = "A question with the same text already exists and was not imported: " . $row[0];
        }
    }

    // Method to return the count of new entries
    public function getNewEntriesCount()
    {
        return $this->newEntriesCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function findOrCreateModuleUnitTopic($row)
    {
        // Assume module name is in column K, unit name in column L, and topic name in column J
        $moduleName = isset($row[10]) && trim($row[10]) !== '' ? $row[10] : null;
        $unitName = isset($row[11]) && trim($row[11]) !== '' ? $row[11] : null;
        $topicName = isset($row[9]) && trim($row[9]) !== '' ? $row[9] : null;

        $module = $unit = $topic = null;

        // Adjusting for polymorphic relationships
        if ($moduleName) {
            $module = Module::firstOrCreate(['name' => $moduleName]);
        }

        if ($module && $unitName) {
            $unit = $module->units()->firstOrCreate(['name' => $unitName]);
        }

        if ($topicName) {
            // Use firstOrNew to avoid duplicate entries and provide a way to handle existing topics
            $topic = Topic::firstOrNew([
                'name' => $topicName,
                'topicable_id' => $this->quizzableId,
                'topicable_type' => get_class($this->quizzable)
            ]);

            // Set additional details if the topic is new
            if (!$topic->exists) {
                $topic->unit_id = $unit ? $unit->id : null; // Associate with a unit if specified
                $topic->save(); // Save only if it's new
            }
        }

        return ['module' => $module, 'unit' => $unit, 'topic' => $topic];
    }
}
