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
            $mathQuestions = DB::table('subjects')
                ->where('name', 'Mathematics')
                ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $mathQuestions to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $mathQuestions is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();


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
                'explanation' => '<p>π (Pi) is a mathematical constant representing the ratio of a circle\'s circumference to its diameter. It is approximately equal to 3.14159, making it the correct choice among the options provided.</p>',
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
                'explanation' => '<p>Let x be the larger number and y the smaller number. We have two equations:</p>
                          <ul>
                              <li>x + y = 20 (Equation 1: Sum of numbers)</li>
                              <li>x - y = 4 (Equation 2: Difference of numbers)</li>
                          </ul>
                          <p>To find x, add Equation 2 to Equation 1:</p>
                          <p>(x + y) + (x - y) = 20 + 4</p>
                          <p>2x = 24</p>
                          <p>Divide both sides by 2 to solve for x:</p>
                          <p>x = 24 / 2</p>
                          <p>x = 12</p>
                          <p>Therefore, the larger number is <strong>12</strong>.</p>'
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
                'explanation' => '<p>The derivative of a function gives us the rate at which the function\'s value changes. For <strong>f(x) = x^2</strong>, the derivative, denoted as <strong>f\'(x)</strong> or <strong>dy/dx</strong>, is found using the power rule. The power rule states that if <strong>f(x) = x^n</strong>, then <strong>f\'(x) = n*x^(n-1)</strong>.</p>
                                 <p>Applying the power rule:</p>
                                 <p><strong>f\'(x) = 2*x^(2-1) = 2x</strong></p>
                                 <p>Therefore, the derivative of <strong>x^2</strong> with respect to x is <strong>2x</strong>.</p>'
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
                'explanation' => '<p>The area <em>A</em> of a circle is calculated using the formula <em>A = πr<sup>2</sup></em>, where <em>π</em> (Pi) is a mathematical constant approximately equal to 3.14159, and <em>r</em> is the radius of the circle.</p>
                      <p>Given a circle with a radius of 5 units:</p>
                      <ul>
                          <li>Substitute <em>r</em> with 5 into the formula: <em>A = π(5)<sup>2</sup> = 25π</em>.</li>
                      </ul>
                      <p>Therefore, the area of the circle is <strong>25π</strong> square units, making the correct answer <strong>25π</strong>.</p>'
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
                'explanation' => '<p>To solve the equation <strong>2x - 4 = 10</strong> for x, follow these steps:</p>
                                  <ol>
                                     <li>Add 4 to both sides of the equation to isolate terms involving x on one side:</li>
                                     <p><strong>2x - 4 + 4 = 10 + 4</strong></p>
                                     <p><strong>2x = 14</strong></p>
                                     <li>Divide both sides by 2 to solve for x:</li>
                                     <p><strong>2x / 2 = 14 / 2</strong></p>
                                     <p><strong>x = 7</strong></p>
                                     </ol>
                                     <p>Therefore, the solution to the equation is <strong>x = 7</strong>.</p>'
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
                'explanation' => '<p>The slope of any line perpendicular to a given line is the negative reciprocal of the slope of the given line. The slope of the line <strong>y = 3x + 1</strong> is 3. Therefore, the slope of a line perpendicular to it would be <strong>-1/3</strong>.</p>',
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
                'explanation' => '<p>This sequence is a geometric progression where each term is multiplied by 2 to get the next term: 2 &times; 2 = 4, 4 &times; 2 = 8, 8 &times; 2 = 16. Continuing this pattern, the next number after 16, obtained by multiplying by 2, is <strong>32</strong>.</p>',
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
                'explanation' => '<p>The square root of a number is a value that, when multiplied by itself, gives the original number. The square root of 144 is <strong>12</strong> since 12 &times; 12 = 144.</p>',
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
                'explanation' => '<p>The integral of <strong>x</strong> with respect to <strong>x</strong> is calculated as <strong>1/2 x^2 + C</strong>, where <strong>C</strong> is the constant of integration. This is derived from the reverse process of differentiation, applying the power rule for integrals.</p>',
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
                'explanation' => '<p>A triangle with sides of length 3, 4, and 5 units forms a right-angled triangle. This can be verified using Pythagoras\' theorem, which states that in a right-angled triangle, the square of the length of the hypotenuse (the side opposite the right angle) is equal to the sum of the squares of the lengths of the other two sides: 3^2 + 4^2 = 9 + 16 = 25, which is equal to 5^2.</p>',
            ],
            // ... add the remaining questions in the same format
        ];

        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $mathQuestions->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $mathQuestions->id,
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
                'quizzable_id' => $mathQuestions->id,
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
