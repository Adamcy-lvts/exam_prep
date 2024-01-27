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



    public function __construct($quizzableType, $quizzableId, $totalMarks)
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
        $this->totalMarks = $totalMarks;
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
            'title' => $this->quizzable->name ?? $this->quizzable->title.' '. $this->quizzable->course_code,
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

        // Create the question with the associated topic ID
        $questionData = [
            'question' => $row[0],
            'marks' => $row[1],
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'quiz_id' => $this->quizId,
            'type' => $row[7],
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        ];
        $question = Question::create($questionData);

        // Get the correct option's content from the 'Is. Correct' column
        $correctOptionContent = $row[6];

        // Loop through options (Columns C through F)
        for ($i = 2; $i <= 5; $i++) {
            $optionValue = $row[$i];

            // Determine if this option is the correct one based on its content
            $isCorrect = ($correctOptionContent === $optionValue) ? 1 : 0;

            // Store the option. Assuming you have a related Option model.
            // Make sure to adjust with the actual relation method you have
            $question->options()->create([
                'option' => $optionValue,
                'is_correct' => $isCorrect,
            ]);
        }
    }

    protected function importTrueOrFalseQuestion($row)
    {
        // Determine the topic for the question
        $moduleUnitTopic  = $this->findOrCreateModuleUnitTopic($row);

        // Create the question with the associated topic ID
        $question = Question::create([
            'question' => $row[0],
            'quiz_id' => $this->quizId,
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'type' => $row[7],
            'answer_text' => $row[8], // Store the correct answer as 'True' or 'False'
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        ]);
    }

    protected function importShortAnswerQuestion($row)
    {
        // Determine the topic for the question
        $moduleUnitTopic  = $this->findOrCreateModuleUnitTopic($row);

        // Create the question
        $question = Question::create([
            'question' => $row[0],
            'quiz_id' => $this->quizId,
            'marks' => $row[1],
            'quizzable_id' => $this->quizzableId,
            'quizzable_type' => $this->quizzable->getMorphClass(),
            'type' => $row[7],
            'answer_text' => $row[8],
            'topic_id' => $moduleUnitTopic['topic'] ? $moduleUnitTopic['topic']->id : null,
        ]);
    }


    // Method to find or create the module, unit, and topic
    protected function findOrCreateModuleUnitTopic($row)
    {
        // Assume module name is in column K and unit name is in column L
        $moduleName = isset($row[10]) && trim($row[10]) !== '' ? $row[10] : null;
        $unitName = isset($row[11]) && trim($row[11]) !== '' ? $row[11] : null;
        $topicName = isset($row[9]) && trim($row[9]) !== '' ? $row[9] : null;

        $module = null;
        $unit = null;
        $topic = null;

        // Find or create the module
        if ($moduleName) {
            $module = Module::firstOrCreate([
                'name' => $moduleName,
                'course_id' => $this->quizzableId,
            ]);
        }

        // Find or create the unit
        if ($module && $unitName) {
            $unit = Unit::firstOrCreate([
                'name' => $unitName,
                'module_id' => $module->id
            ]);
        }

        // Find or create the topic
        if ($unit && $topicName) {
            $topic = Topic::firstOrCreate([
                'name' => $topicName,
                'unit_id' => $unit->id,
                'course_id' => $this->quizzableId,
            ]);
        }

        return ['module' => $module, 'unit' => $unit, 'topic' => $topic];
    }
}
