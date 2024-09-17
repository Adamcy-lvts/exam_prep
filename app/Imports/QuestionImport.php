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
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class QuestionImport implements ToCollection, WithHeadingRow
{
    // Properties to store import-related data
    protected $quizzable;
    protected $quizId;
    public $errors = [];
    private $newEntriesCount = 0;

    /**
     * Constructor to initialize the import with quizzable type and ID
     *
     * @param string $quizzableType 'course' or 'subject'
     * @param int $quizzableId ID of the course or subject
     */
    public function __construct($quizzableType, $quizzableId)
    {
        // Determine the quizzable model based on the type
        $this->quizzable = $quizzableType == 'course'
            ? Course::findOrFail($quizzableId)
            : Subject::findOrFail($quizzableId);
    }

    /**
     * Main method to process the imported collection
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Create or update the quiz
        $quiz = $this->createOrUpdateQuiz($rows);

        // Process each row (question) in the collection
        foreach ($rows as $row) {
            $this->processQuestion($row, $quiz);
        }
    }

    /**
     * Create or update the quiz based on the imported data
     *
     * @param Collection $rows
     * @return Quiz
     */
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

    /**
     * Process a single question row
     *
     * @param array $row
     * @param Quiz $quiz
     */
    protected function processQuestion($row, $quiz)
    {
        // Find or create module, unit, and topic
        $moduleUnitTopic = $this->findOrCreateModuleUnitTopic($row);

        // Create or update the question
        $question = Question::updateOrCreate(
            [
                'question' => $row['question'],
                'quiz_id' => $quiz->id,
            ],
            [
                'marks' => $row['mark'],
                'quizzable_id' => $this->quizzable->id,
                'quizzable_type' => get_class($this->quizzable),
                'type' => strtolower($row['type']),
                'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
                'explanation' => $row['explanation'] ?? null,
            ]
        );

        // Handle new entries and options
        if ($question->wasRecentlyCreated) {
            $this->newEntriesCount++;
            $this->handleOptions($question, $row);
        } else {
            $this->errors[] = "Question updated (not newly created): " . $row['question'];
        }
    }

    /**
     * Handle options for MCQ and True/False questions
     *
     * @param Question $question
     * @param array $row
     */
    protected function handleOptions($question, $row)
    {
        $optionColumns = ['option_a', 'option_b', 'option_c', 'option_d'];
        $correctAnswer = $row['is_correct'];

        foreach ($optionColumns as $index => $column) {
            if (isset($row[$column]) && $row[$column] !== null) {
                $isCorrect = strtoupper($correctAnswer) === chr(65 + $index); // A, B, C, D
                $question->options()->create([
                    'option' => $row[$column],
                    'is_correct' => $isCorrect,
                ]);
            }
        }

        // Handle SAQ and T/F answer text
        if ($question->type === 'saq' || $question->type === 'tf') {
            $question->answer_text = $correctAnswer;
            $question->save();
        }
    }

    /**
     * Find or create module, unit, and topic based on the row data
     *
     * @param array $row
     * @return array
     */
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

    /**
     * Get the count of new entries
     *
     * @return int
     */
    public function getNewEntriesCount()
    {
        return $this->newEntriesCount;
    }

    /**
     * Get any errors that occurred during import
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
