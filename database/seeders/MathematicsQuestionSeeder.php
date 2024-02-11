<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MathematicsQuestionSeeder extends Seeder
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
                ->where('name', 'Mathematics')
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
                'question' => 'What is the value of π (Pi)?',
                'marks' => 2,
                'options' => [
                    ['option' => '3.14159', 'is_correct' => true],
                    ['option' => '2.71828', 'is_correct' => false],
                    ['option' => '1.61803', 'is_correct' => false],
                    ['option' => '1.41421', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'If the sum of two numbers is 20 and their difference is 4, what is the larger number?',
                'marks' => 2,
                'options' => [
                    ['option' => '12', 'is_correct' => true],
                    ['option' => '8', 'is_correct' => false],
                    ['option' => '16', 'is_correct' => false],
                    ['option' => '10', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the derivative of x^2?',
                'marks' => 2,
                'options' => [
                    ['option' => 'x', 'is_correct' => false],
                    ['option' => '2x', 'is_correct' => true],
                    ['option' => 'x^2/2', 'is_correct' => false],
                    ['option' => '2x^2', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the area of a circle with a radius of 5 units?',
                'marks' => 2,
                'options' => [
                    ['option' => '25π', 'is_correct' => true],
                    ['option' => '10π', 'is_correct' => false],
                    ['option' => '75π', 'is_correct' => false],
                    ['option' => '50π', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Solve for x in the equation 2x - 4 = 10.',
                'marks' => 2,
                'options' => [
                    ['option' => '5', 'is_correct' => false],
                    ['option' => '7', 'is_correct' => true],
                    ['option' => '3', 'is_correct' => false],
                    ['option' => '8', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the slope of a line perpendicular to the line y = 3x + 1?',
                'marks' => 2,
                'options' => [
                    ['option' => '3', 'is_correct' => false],
                    ['option' => '-3', 'is_correct' => false],
                    ['option' => '1/3', 'is_correct' => false],
                    ['option' => '-1/3', 'is_correct' => true],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the next number in the sequence: 2, 4, 8, 16, ...?',
                'marks' => 2,
                'options' => [
                    ['option' => '32', 'is_correct' => true],
                    ['option' => '18', 'is_correct' => false],
                    ['option' => '24', 'is_correct' => false],
                    ['option' => '64', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the value of the square root of 144?',
                'marks' => 2,
                'options' => [
                    ['option' => '12', 'is_correct' => true],
                    ['option' => '14', 'is_correct' => false],
                    ['option' => '13', 'is_correct' => false],
                    ['option' => '16', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the result of the integral ∫ x dx?',
                'marks' => 2,
                'options' => [
                    ['option' => '1/2 x^2 + C', 'is_correct' => true],
                    ['option' => 'x^2 + C', 'is_correct' => false],
                    ['option' => 'x + C', 'is_correct' => false],
                    ['option' => '1/2 x^2', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'If a triangle has sides of length 3, 4, and 5, what type of triangle is it?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Equilateral', 'is_correct' => false],
                    ['option' => 'Isosceles', 'is_correct' => false],
                    ['option' => 'Right-angled', 'is_correct' => true],
                    ['option' => 'Acute', 'is_correct' => false],
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
