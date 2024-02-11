<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChemistryQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the 'Physics' subject by its unique name
        $jambExamId = DB::table('exams')->where('exam_name', 'JAMB')->value('id');

        // Check if the 'JAMB' exam ID was retrieved successfully
        if ($jambExamId) {
            // Retrieve the 'Physics' subject for the 'JAMB' exam
            $physicsSubjectForJAMB = DB::table('subjects')
            ->where('name', 'Chemistry')
            ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $physicsSubjectForJAMB to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $physicsSubjectForJAMB is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $physicsSubjectForJAMB->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $physicsSubjectForJAMB->id,
            'total_marks' => 20, // Sum of marks for all questions
            'duration' => 60, // Example default value
            'total_questions' => 10, // Total number of questions
            'max_attempts' => 3, // Example default value
        ]);

        $questions = [
            [
                'question' => 'What is the chemical symbol for Gold?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Au', 'is_correct' => true],
                    ['option' => 'Ag', 'is_correct' => false],
                    ['option' => 'Fe', 'is_correct' => false],
                    ['option' => 'Cu', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the most abundant gas in the Earth\'s atmosphere?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Hydrogen', 'is_correct' => false],
                    ['option' => 'Nitrogen', 'is_correct' => true],
                    ['option' => 'Carbon dioxide', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which element has the highest electronegativity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Fluorine', 'is_correct' => true],
                    ['option' => 'Chlorine', 'is_correct' => false],
                    ['option' => 'Bromine', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What type of bond is formed when electrons are transferred from one atom to another?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Covalent bond', 'is_correct' => false],
                    ['option' => 'Ionic bond', 'is_correct' => true],
                    ['option' => 'Hydrogen bond', 'is_correct' => false],
                    ['option' => 'Metallic bond', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the pH value of pure water at 25°C?',
                'marks' => 2,
                'options' => [
                    ['option' => '7', 'is_correct' => true],
                    ['option' => '5', 'is_correct' => false],
                    ['option' => '8', 'is_correct' => false],
                    ['option' => '9', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'The process of converting a liquid to a gas is called what?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Condensation', 'is_correct' => false],
                    ['option' => 'Evaporation', 'is_correct' => true],
                    ['option' => 'Sublimation', 'is_correct' => false],
                    ['option' => 'Deposition', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the formula for calculating molarity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'moles of solute/liters of solution', 'is_correct' => true],
                    ['option' => 'moles of solute/moles of solvent', 'is_correct' => false],
                    ['option' => 'liters of solute/moles of solution', 'is_correct' => false],
                    ['option' => 'grams of solute/liters of solution', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which gas is produced when hydrochloric acid reacts with sodium hydroxide?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Hydrogen', 'is_correct' => true],
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Chlorine', 'is_correct' => false],
                    ['option' => 'None', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the main component of natural gas?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Methane', 'is_correct' => true],
                    ['option' => 'Ethane', 'is_correct' => false],
                    ['option' => 'Propane', 'is_correct' => false],
                    ['option' => 'Butane', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which vitamin is produced by the human skin in response to sunlight?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Vitamin A', 'is_correct' => false],
                    ['option' => 'Vitamin B', 'is_correct' => false],
                    ['option' => 'Vitamin C', 'is_correct' => false],
                    ['option' => 'Vitamin D', 'is_correct' => true],
                ],
                'type' => 'mcq',
            ],
            // ... add the remaining questions in the same format
        ];

        foreach ($questions as $questionData) {
            // Create a new question for the quiz
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'quizzable_type' => Subject::class,
                'quizzable_id' => $physicsSubjectForJAMB->id,
                'question' => $questionData['question'],
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
                'answer_text' => $questionData['answer_text'] ?? null, // Provide a default null if 'answer_text' is not set

            ]);

            // Create options for the question
            if (array_key_exists('options', $questionData)) {
                foreach ($questionData['options'] as $optionData) {
                    Option::create([
                        'question_id' => $question->id,
                        'option' => $optionData['option'],
                        'is_correct' => $optionData['is_correct'],
                    ]);
                }
            }
        }
    }
}
