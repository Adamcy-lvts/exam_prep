<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EnglishQuestionSeeder extends Seeder
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
            ->where('name', 'Use of English')
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
                'question' => 'Choose the correct form of the verb: She ___ to the store.',
                'marks' => 2,
                'options' => [
                    ['option' => 'go', 'is_correct' => false],
                    ['option' => 'goes', 'is_correct' => false],
                    ['option' => 'went', 'is_correct' => true],
                    ['option' => 'going', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Identify the synonym of "quick":',
                'marks' => 2,
                'options' => [
                    ['option' => 'Slow', 'is_correct' => false],
                    ['option' => 'Sluggish', 'is_correct' => false],
                    ['option' => 'Rapid', 'is_correct' => true],
                    ['option' => 'Lazy', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which word is spelled incorrectly?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Necessary', 'is_correct' => false],
                    ['option' => 'Definately', 'is_correct' => true], // 'Definitely' is the correct spelling
                    ['option' => 'Immediately', 'is_correct' => false],
                    ['option' => 'Accidentally', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the antonym of "ancient"?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Old', 'is_correct' => false],
                    ['option' => 'Historic', 'is_correct' => false],
                    ['option' => 'Modern', 'is_correct' => true],
                    ['option' => 'Past', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],

            [
                'question' => 'Identify the correct passive form: "The book was read by her."',
                'marks' => 2,
                'options' => [
                    ['option' => 'She was read the book.', 'is_correct' => false],
                    ['option' => 'She read the book.', 'is_correct' => false],
                    ['option' => 'The book was reading by her.', 'is_correct' => false],
                    ['option' => 'The book read by her.', 'is_correct' => true],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which sentence is grammatically correct?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Him and I went home.', 'is_correct' => false],
                    ['option' => 'He and I went home.', 'is_correct' => true],
                    ['option' => 'He and me went home.', 'is_correct' => false],
                    ['option' => 'Him and me went home.', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Choose the word that correctly fills the gap: "She is ___ to win the race."',
                'marks' => 2,
                'options' => [
                    ['option' => 'like', 'is_correct' => false],
                    ['option' => 'liking', 'is_correct' => false],
                    ['option' => 'likely', 'is_correct' => true],
                    ['option' => 'liken', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Select the correctly punctuated sentence:',
                'marks' => 2,
                'options' => [
                    ['option' => 'Its a beautiful day.', 'is_correct' => false],
                    ['option' => 'It\'s a beautiful day.', 'is_correct' => true],
                    ['option' => 'It,s a beautiful day.', 'is_correct' => false],
                    ['option' => 'Its a beautiful day.', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Choose the word that is spelled correctly:',
                'marks' => 2,
                'options' => [
                    ['option' => 'Reccommend', 'is_correct' => false],
                    ['option' => 'Recommend', 'is_correct' => true],
                    ['option' => 'Recomend', 'is_correct' => false],
                    ['option' => 'Reccommend', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the plural form of "mouse"?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Mouses', 'is_correct' => false],
                    ['option' => 'Mice', 'is_correct' => true],
                    ['option' => 'Mousees', 'is_correct' => false],
                    ['option' => 'Meese', 'is_correct' => false],
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
