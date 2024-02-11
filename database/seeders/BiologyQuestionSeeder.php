<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BiologyQuestionSeeder extends Seeder
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
            ->where('name', 'Biology')
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
                'question' => 'What is the basic unit of life?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Cell', 'is_correct' => true],
                    ['option' => 'Atom', 'is_correct' => false],
                    ['option' => 'Molecule', 'is_correct' => false],
                    ['option' => 'Organ', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which organ system is responsible for transport of nutrients?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nervous System', 'is_correct' => false],
                    ['option' => 'Circulatory System', 'is_correct' => true],
                    ['option' => 'Endocrine System', 'is_correct' => false],
                    ['option' => 'Respiratory System', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the process by which plants make their food?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Photosynthesis', 'is_correct' => true],
                    ['option' => 'Respiration', 'is_correct' => false],
                    ['option' => 'Digestion', 'is_correct' => false],
                    ['option' => 'Transpiration', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which molecule carries genetic information?',
                'marks' => 2,
                'options' => [
                    ['option' => 'DNA', 'is_correct' => true],
                    ['option' => 'RNA', 'is_correct' => false],
                    ['option' => 'Protein', 'is_correct' => false],
                    ['option' => 'Lipid', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the powerhouse of the cell?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleus', 'is_correct' => false],
                    ['option' => 'Mitochondria', 'is_correct' => true],
                    ['option' => 'Chloroplast', 'is_correct' => false],
                    ['option' => 'Ribosome', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What are the building blocks of proteins?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleotides', 'is_correct' => false],
                    ['option' => 'Amino acids', 'is_correct' => true],
                    ['option' => 'Fatty acids', 'is_correct' => false],
                    ['option' => 'Monosaccharides', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'Which part of the brain controls balance and coordination?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Cerebrum', 'is_correct' => false],
                    ['option' => 'Cerebellum', 'is_correct' => true],
                    ['option' => 'Brainstem', 'is_correct' => false],
                    ['option' => 'Hypothalamus', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'In which cell organelle does cellular respiration occur?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleus', 'is_correct' => false],
                    ['option' => 'Endoplasmic reticulum', 'is_correct' => false],
                    ['option' => 'Golgi apparatus', 'is_correct' => false],
                    ['option' => 'Mitochondria', 'is_correct' => true],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What is the term for a group of similar cells performing the same function?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Tissue', 'is_correct' => true],
                    ['option' => 'Organ', 'is_correct' => false],
                    ['option' => 'Organ system', 'is_correct' => false],
                    ['option' => 'Organism', 'is_correct' => false],
                ],
                'type' => 'mcq',
            ],
            [
                'question' => 'What type of blood cells are responsible for immunity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Red blood cells', 'is_correct' => false],
                    ['option' => 'White blood cells', 'is_correct' => true],
                    ['option' => 'Platelets', 'is_correct' => false],
                    ['option' => 'Plasma cells', 'is_correct' => false],
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
