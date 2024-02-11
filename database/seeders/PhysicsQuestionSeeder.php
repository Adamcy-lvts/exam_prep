<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhysicsQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve the 'Physics' subject by its unique name
        $jambExamId = DB::table('exams')->where('exam_name', 'JAMB')->value('id');

        // Check if the 'JAMB' exam ID was retrieved successfully
        if ($jambExamId) {
            // Retrieve the 'Physics' subject for the 'JAMB' exam
            $physicsSubjectForJAMB = DB::table('subjects')
                ->where('name', 'Physics')
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

        // Array of questions and options based on the image you've provided
        $questions = [
            [
                'question' => 'What is the SI unit of force?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Newton', 'is_correct' => true],
                    ['option' => 'Pascal', 'is_correct' => false],
                    ['option' => 'Joule', 'is_correct' => false],
                    ['option' => 'Watt', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Who formulated the law of motion?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Isaac Newton', 'is_correct' => true],
                    ['option' => 'Albert Einstein', 'is_correct' => false],
                    ['option' => 'Niels Bohr', 'is_correct' => false],
                    ['option' => 'James Clerk Maxwell', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What does "E" represent in E=mc^2?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Energy', 'is_correct' => true],
                    ['option' => 'Electricity', 'is_correct' => false],
                    ['option' => 'Mass', 'is_correct' => false],
                    ['option' => 'Speed', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the basic unit of electric current?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Volt', 'is_correct' => false],
                    ['option' => 'Ampere', 'is_correct' => true],
                    ['option' => 'Ohm', 'is_correct' => false],
                    ['option' => 'Joule', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What device is used to measure electric current?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oscilloscope', 'is_correct' => false],
                    ['option' => 'Barometer', 'is_correct' => false],
                    ['option' => 'Ammeter', 'is_correct' => true],
                    ['option' => 'Voltmeter', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the speed of light in vacuum?',
                'marks' => 2,
                'type' => 'saq',
                'answer_text' => '300,000 km/s'
            ],
            [
                'question' => 'Which law states that energy cannot be created or destroyed?',
                'marks' => 2,
                'options' => [
                    ['option' => 'First law of thermodynamics', 'is_correct' => true],
                    ['option' => 'Second law of thermodynamics', 'is_correct' => false],
                    ['option' => 'Law of conservation of mass', 'is_correct' => false],
                    ['option' => 'Law of conservation of energy', 'is_correct' => false],
                ],
                'type' => 'mcq',

            ],
            [
                'question' => 'Which force acts between two charges?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Gravitational', 'is_correct' => false],
                    ['option' => 'Electromagnetic', 'is_correct' => false],
                    ['option' => 'Frictional', 'is_correct' => false],
                    ['option' => 'Electrostatic', 'is_correct' => true],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the charge of an electron?',
                'marks' => 2,
                'options' => [
                    ['option' => '-1.6 x 10^-19 C', 'is_correct' => true],
                    ['option' => 'Zero', 'is_correct' => false],
                    ['option' => '1.6 x 10^-19 C', 'is_correct' => false],
                    ['option' => '+1.6 x 10^-19 C', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the focal length of a plane mirror?',
                'marks' => 2,
                'type' => 'saq',
                'answer_text' => 'Infinity'

            ],
            // ... Add all other questions here in the same format
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
