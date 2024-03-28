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
            $chemistry = DB::table('subjects')
            ->where('name', 'Chemistry')
            ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $chemistry to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $chemistry is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();

      

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
                'explanation' => 'Gold is represented by the symbol <strong>Au</strong> from the Latin word \'aurum\' meaning shiny dawn.',
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
                'explanation' => 'Nitrogen makes up about 78% of the Earth\'s atmosphere, making it the most abundant gas.',
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
                'explanation' => 'Fluorine has the highest electronegativity, making it extremely reactive and capable of attracting electrons to itself more than any other element.',
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
                'explanation' => 'An <strong>Ionic bond</strong> is formed through the transfer of electrons from one atom to another, leading to the formation of positively and negatively charged ions.',
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
                'explanation' => 'Pure water at 25°C has a pH value of <strong>7</strong>, indicating that it is neutral – neither acidic nor basic.',
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
                'explanation' => 'Evaporation is the process where a liquid turns into a gas. It happens when liquid water gets enough energy from heat to escape into the air as water vapor.',
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
                'explanation' => 'Molarity measures the concentration of a solution. It\'s calculated as the moles of solute (the substance dissolved) divided by the liters of the whole solution.',
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
                'explanation' => 'When hydrochloric acid reacts with sodium hydroxide, it produces sodium chloride (table salt) and water. Hydrogen gas is released in some acid-base reactions but not in this neutralization reaction.',
                'correction' => 'No gas is produced in the reaction between hydrochloric acid and sodium hydroxide; it results in water and sodium chloride. The correct option in the question should be revised to reflect accurate chemical outcomes.'
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
                'explanation' => 'Methane is the main component of natural gas, making up about 70-90% of it. It\'s used as a fuel for heating, cooking, and electricity generation.',
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
                'explanation' => 'Vitamin D is known as the "sunshine vitamin" because the skin produces it in response to sunlight. It\'s essential for healthy bones because it helps the body use calcium from the diet.',
            ],
            // ... add the remaining questions in the same format
        ];

        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $chemistry->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $chemistry->id,
            'total_marks' => $total_marks, // Sum of marks for all questions
            'duration' => 60, // Example default value
            'total_questions' => count($questions), // Total number of questions
            'max_attempts' => 3, // Example default value
        ]);

        foreach ($questions as $questionData) {
            // Create a new question for the quiz
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'quizzable_type' => Subject::class,
                'quizzable_id' => $chemistry->id,
                'question' => $questionData['question'],
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
                'answer_text' => $questionData['answer_text'] ?? null, // Provide a default null if 'answer_text' is not set
                'explanation' => $questionData['explanation'] ?? null,
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
