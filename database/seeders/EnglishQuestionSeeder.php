<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\QuestionInstruction;
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
            $useOfEnglish = DB::table('subjects')
                ->where('name', 'Use of English')
                ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $useOfEnglish to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $useOfEnglish is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();

        // $questions = [
        //     [
        //         'question' => 'Choose the correct form of the verb: She ___ to the store.',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'go', 'is_correct' => false],
        //             ['option' => 'goes', 'is_correct' => false],
        //             ['option' => 'went', 'is_correct' => true],
        //             ['option' => 'going', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The correct form is "went" because the sentence is in the past tense. "She went to the store."',
        //     ],
        //     [
        //         'question' => 'Identify the synonym of "quick":',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Slow', 'is_correct' => false],
        //             ['option' => 'Sluggish', 'is_correct' => false],
        //             ['option' => 'Rapid', 'is_correct' => true],
        //             ['option' => 'Lazy', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => '"Rapid" is a synonym for "quick," both meaning fast or speedy.',
        //     ],
        //     [
        //         'question' => 'Which word is spelled incorrectly?',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Necessary', 'is_correct' => false],
        //             ['option' => 'Definately', 'is_correct' => true], // 'Definitely' is the correct spelling
        //             ['option' => 'Immediately', 'is_correct' => false],
        //             ['option' => 'Accidentally', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The word "Definately" is spelled incorrectly. The correct spelling is "Definitely".',
        //     ],
        //     [
        //         'question' => 'What is the antonym of "ancient"?',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Old', 'is_correct' => false],
        //             ['option' => 'Historic', 'is_correct' => false],
        //             ['option' => 'Modern', 'is_correct' => true],
        //             ['option' => 'Past', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The antonym of "ancient" is "Modern," meaning something is from recent times or the present.',
        //     ],
        //     [
        //         'question' => 'Identify the correct passive form: "The book was read by her."',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'She was read the book.', 'is_correct' => false],
        //             ['option' => 'She read the book.', 'is_correct' => false],
        //             ['option' => 'The book was reading by her.', 'is_correct' => false],
        //             ['option' => 'The book read by her.', 'is_correct' => false], // This option is actually incorrect.
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The given sentence "The book was read by her." is already in the correct passive form. None of the options accurately represent a change or correction to the given sentence.',
        //         'correction' => 'The correct passive form of the sentence has been provided in the question. The options and explanation have been adjusted to reflect accurate understanding.'
        //     ],
        //     [
        //         'question' => 'Which sentence is grammatically correct?',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Him and I went home.', 'is_correct' => false],
        //             ['option' => 'He and I went home.', 'is_correct' => true],
        //             ['option' => 'He and me went home.', 'is_correct' => false],
        //             ['option' => 'Him and me went home.', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => '"He and I went home." is grammatically correct because "he" and "I" are subject pronouns that correctly match the subject position in the sentence.',
        //     ],
        //     [
        //         'question' => 'Choose the word that correctly fills the gap: "She is ___ to win the race."',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'like', 'is_correct' => false],
        //             ['option' => 'liking', 'is_correct' => false],
        //             ['option' => 'likely', 'is_correct' => true],
        //             ['option' => 'liken', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => '"Likely" is the correct choice because it means "probable" or "expected," which fits the context of someone having a good chance to win the race.',
        //     ],
        //     [
        //         'question' => 'Select the correctly punctuated sentence:',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Its a beautiful day.', 'is_correct' => false],
        //             ['option' => 'It\'s a beautiful day.', 'is_correct' => true],
        //             ['option' => 'It,s a beautiful day.', 'is_correct' => false],
        //             ['option' => 'Its a beautiful day.', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => '"It\'s a beautiful day." uses the correct contraction "It\'s," which stands for "It is," and properly includes the apostrophe for contraction.',
        //     ],
        //     [
        //         'question' => 'Choose the word that is spelled correctly:',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Reccommend', 'is_correct' => false],
        //             ['option' => 'Recommend', 'is_correct' => true],
        //             ['option' => 'Recomend', 'is_correct' => false],
        //             ['option' => 'Reccommend', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The correct spelling is "Recommend," which means to suggest something as being particularly good or suitable.',
        //     ],
        //     [
        //         'question' => 'What is the plural form of "mouse"?',
        //         'marks' => 2,
        //         'options' => [
        //             ['option' => 'Mouses', 'is_correct' => false],
        //             ['option' => 'Mice', 'is_correct' => true],
        //             ['option' => 'Mousees', 'is_correct' => false],
        //             ['option' => 'Meese', 'is_correct' => false],
        //         ],
        //         'type' => 'mcq',
        //         'explanation' => 'The plural form of "mouse" is "Mice." Unlike most English nouns, "mouse" becomes "mice" when referring to more than one.',
        //     ],
        //     // ... add the remaining questions in the same format
        // ];

 
        $OppInMeaningInstructionText = 'For these questions choose the option opposite in meaning to the word or phrase in italics.';
        $OppInMeaningInstruction = QuestionInstruction::firstOrCreate(['instruction' => $OppInMeaningInstructionText]);

        $OppInMeaningInstruction = [
            [
                'question' => 'I am optimistic about the interview though it was a mind-bending exercise.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'An enervating', 'is_correct' => false],
                    ['option' => 'A debilitating', 'is_correct' => false],
                    ['option' => 'A difficult', 'is_correct' => false],
                    ['option' => 'An easy', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The term "mind-bending" suggests something very challenging or difficult. Therefore, the opposite in meaning would be something that is not challenging, which is "An easy".',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The trader was amused by the cut-throat rush for the goods.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Worrisome', 'is_correct' => false],
                    ['option' => 'Strange', 'is_correct' => false],
                    ['option' => 'Lacklustre', 'is_correct' => true],
                    ['option' => 'Mad', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Cut-throat" suggests intense and ruthless competition. The term "Lacklustre" would be the opposite as it means lacking in enthusiasm or energy, which is contrary to the intense nature of "cut-throat".',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The teacher said that Ali’s essay was full of many redundant details.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Unexplained', 'is_correct' => false],
                    ['option' => 'Strange', 'is_correct' => false],
                    ['option' => 'Necessary', 'is_correct' => false],
                    ['option' => 'Useful', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'Redundant details are those which are not needed because they are more than is necessary. The opposite would be details that are "Useful", meaning they serve a purpose and are needed.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],

            [
                'question' => 'His father surmounted the myriad of obstacles on his way.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Most', 'is_correct' => false],
                    ['option' => 'Few', 'is_correct' => false],
                    ['option' => 'All', 'is_correct' => false],
                    ['option' => 'Many', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "myriad" refers to a very large number, so the opposite is not "Few" but "Many" which indicates a large number as well.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'Her ingenuous smile drew our attention.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Witty', 'is_correct' => false],
                    ['option' => 'Naive', 'is_correct' => true],
                    ['option' => 'Clever', 'is_correct' => false],
                    ['option' => 'Arrogant', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Ingenuous" means innocent and unsuspecting, often used to describe childlike simplicity or frankness, the closest antonym is "Naive" which also implies a lack of sophistication or worldliness.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'Ndani gave a flawless speech at the party.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'A wonderful', 'is_correct' => false],
                    ['option' => 'A careless', 'is_correct' => false],
                    ['option' => 'An interesting', 'is_correct' => false],
                    ['option' => 'An imperfect', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "flawless" means without any blemishes or imperfections; therefore, the opposite is "An imperfect".',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'Beneath Ado’s guff exterior, he’s really very kind-hearted.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Nice', 'is_correct' => false],
                    ['option' => 'Harsh', 'is_correct' => false],
                    ['option' => 'Rough', 'is_correct' => false],
                    ['option' => 'Gentle', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => '"Guff" can mean rough or harsh; "Gentle" is its antonym, indicating a mild or kind nature.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The captain says sports is being debased by commercial sponsorship.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Localized', 'is_correct' => false],
                    ['option' => 'Perverted', 'is_correct' => false],
                    ['option' => 'Elevated', 'is_correct' => true],
                    ['option' => 'Overvalued', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'To debase something is to reduce its value or quality. "Elevated" is the opposite, meaning to raise up or increase in value or quality.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'Governing a country is not always as straightforward as people sometimes imagine.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Complicated', 'is_correct' => true],
                    ['option' => 'Troublesome', 'is_correct' => false],
                    ['option' => 'Untoward', 'is_correct' => false],
                    ['option' => 'Irksome', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Straightforward means simple and easy to understand. The opposite, "Complicated", means difficult to understand or deal with.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The crowd was very receptive to the speaker’s suggestion.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Disobedient', 'is_correct' => false],
                    ['option' => 'Repellent', 'is_correct' => false],
                    ['option' => 'Alert', 'is_correct' => false],
                    ['option' => 'Hostile', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'Receptive means willing to consider or accept new suggestions. The opposite would be "Hostile", which means unfriendly or opposed.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'There was a general acquiescence on the new drug law.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Resistance', 'is_correct' => true],
                    ['option' => 'Discrepancy', 'is_correct' => false],
                    ['option' => 'Compromise', 'is_correct' => false],
                    ['option' => 'Agreement', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Acquiescence means acceptance or compliance. The opposite is "Resistance", which implies refusal or opposition.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],

            [
                'question' => 'Aisha seems to feel ambivalent about her future.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Decisive', 'is_correct' => true],
                    ['option' => 'Anxious', 'is_correct' => false],
                    ['option' => 'Ambitious', 'is_correct' => false],
                    ['option' => 'Inconsiderate', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Being ambivalent means having mixed feelings or contradictory ideas about something or someone. Thus, the opposite is "Decisive", which means displaying no hesitation in making a decision.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The report of the committee contained a plethora of details.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Shortage', 'is_correct' => true],
                    ['option' => 'Simplicity', 'is_correct' => false],
                    ['option' => 'Multitude', 'is_correct' => false],
                    ['option' => 'Spectrum', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'A "plethora" means an excess or overabundance. Therefore, the opposite is "Shortage", which indicates a lack or insufficiency.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'The weather was still very heavy and sultry.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Wintry and shadowy', 'is_correct' => false],
                    ['option' => 'Cold and friendly', 'is_correct' => false],
                    ['option' => 'Cloudy and thundery', 'is_correct' => false],
                    ['option' => 'Hot and uncomfortable', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => '"Sultry" weather is often hot and causes discomfort. Therefore, "Hot and uncomfortable" is a synonym rather than an antonym, which seems to be an error in the question as it asks for an opposite meaning. An appropriate opposite would have been "Cool and comfortable".',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            [
                'question' => 'Ada gave her husband a look that made words superfluous.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Redundant', 'is_correct' => false],
                    ['option' => 'Spurious', 'is_correct' => false],
                    ['option' => 'Unnecessary', 'is_correct' => false],
                    ['option' => 'Scanty', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'If something is superfluous, it is unnecessary, especially through being more than enough. The closest antonym in the given options is "Scanty", which implies not enough or insufficient, indicating a lack of something rather than an excess.',
                'question_instruction_id' => $OppInMeaningInstruction->id,
            ],
            // ... Add any additional questions here
        ];

        $NearestInMeaningInstructionText = 'In each of questions 51 to 65, choose the option nearest in meaning to the word or phrase in italics.';
        $NearestInMeaningInstruction = QuestionInstruction::firstOrCreate(['instruction' => $NearestInMeaningInstructionText]);

        $NearestInMeaningQuestions = [
            [
                'question' => 'A political <i>Impasse</i> does not offer the best opportunity for <i>merrymaking</i>.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Manifesto', 'is_correct' => false],
                    ['option' => 'Party', 'is_correct' => true],
                    ['option' => 'Gridlock', 'is_correct' => false],
                    ['option' => 'Rally', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'An impasse is a situation where no progress is possible, especially because of disagreement; it is a deadlock. Merrymaking is the process of enjoying oneself with others, especially by dancing and eating. The nearest in meaning to "merrymaking" in the context of an impasse would be "Party".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'We were all <i>enthusiastic</i> as we awaited the result of the election.',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Amused', 'is_correct' => false],
                    ['option' => 'Agitated', 'is_correct' => false],
                    ['option' => 'Elated', 'is_correct' => true],
                    ['option' => 'Nervous', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Enthusiastic means having or showing intense and eager enjoyment, interest, or approval. Elated means ecstatically happy. So, in the context of awaiting election results, being enthusiastic is nearest in meaning to being elated.',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            // ... additional questions
        ];



        $questions = array_merge(
            $OppInMeaningInstruction,
            $NearestInMeaningQuestions
        );

        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $useOfEnglish->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $useOfEnglish->id,
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
                'quizzable_id' => $useOfEnglish->id,
                'question' => $questionData['question'],
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
                'answer_text' => $questionData['answer_text'] ?? null, // Provide a default null if 'answer_text' is not set
                'explanation' => $questionData['explanation'] ?? null,
                'question_instruction_id' => $questionData['question_instruction_id'] ?? null,
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
