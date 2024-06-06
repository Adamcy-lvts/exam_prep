<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Topic;
use App\Models\Module;
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

        $NearestInMeaningInstructionText = 'choose the option nearest in meaning to the word or phrase in italics.';
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
        ];
        $GapFillingInstructionText = 'choose the option that best complete the gap';
        $GapFillingInstruction = QuestionInstruction::firstOrCreate(['instruction' => $GapFillingInstructionText]);

        $GapFillingQuestions = [
            [
                'question' => 'When his car tyre ..... on the way, he did not know what to do',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'has burst', 'is_correct' => false],
                    ['option' => 'had burst', 'is_correct' => true],
                    ['option' => 'bursted', 'is_correct' => false],
                    ['option' => 'burst', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct form for the past perfect tense in this context is "had burst".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Lami’s father .... As a gardener when he was young, but now he is a driver',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'had been working', 'is_correct' => false],
                    ['option' => 'use to work', 'is_correct' => false],
                    ['option' => 'has worked', 'is_correct' => false],
                    ['option' => 'used to work', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct form for indicating a past habit is "used to work".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => '........He switches on the light, the shadow disappears',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'whenever', 'is_correct' => true],
                    ['option' => 'except', 'is_correct' => false],
                    ['option' => 'since', 'is_correct' => false],
                    ['option' => 'until', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word to indicate every time is "whenever".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'it is important that you clear the refuse in front of your house every ......',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'fourtnight', 'is_correct' => false],
                    ['option' => 'fortnight', 'is_correct' => true],
                    ['option' => 'fourthnight', 'is_correct' => false],
                    ['option' => 'forthnight', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct term for a period of two weeks is "fortnight".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The policemen became suspicious as the hoodlums...... in their office',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'ferreted', 'is_correct' => true],
                    ['option' => 'ferreted', 'is_correct' => false],
                    ['option' => 'ferreted about', 'is_correct' => false],
                    ['option' => 'ferreted about', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct term to indicate searching or rummaging is "ferreted".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Suara needn’t come with us. ?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'does she', 'is_correct' => true],
                    ['option' => 'will she', 'is_correct' => false],
                    ['option' => 'can she', 'is_correct' => false],
                    ['option' => 'need she', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct tag question for a negative statement with needn’t is "does she".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Unoka.... the whole house to find his missing wristwatch',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'scourged', 'is_correct' => false],
                    ['option' => 'scoured', 'is_correct' => true],
                    ['option' => 'scored', 'is_correct' => false],
                    ['option' => 'scouted', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word to indicate thoroughly searching is "scoured".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Ife asked me....',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'what time it was', 'is_correct' => true],
                    ['option' => 'what is it by my time', 'is_correct' => false],
                    ['option' => 'what time is it', 'is_correct' => false],
                    ['option' => 'what time it is', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct form for indirect speech is "what time it was".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],

            [
                'question' => 'There are many ways to kill a rat, so we should be .... In our approach to the task ahead of us',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'ecletic', 'is_correct' => false],
                    ['option' => 'eclectic', 'is_correct' => true],
                    ['option' => 'eclKtic', 'is_correct' => false],
                    ['option' => 'eclectiK', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word meaning deriving ideas, style, or taste from a broad and diverse range of sources is "eclectic".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Audu took these action purely.... His own career',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'on furtherance of', 'is_correct' => false],
                    ['option' => 'in furtherance of', 'is_correct' => true],
                    ['option' => 'to furtherance in', 'is_correct' => false],
                    ['option' => 'in furtherance with', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct phrase meaning to promote or advance is "in furtherance of".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Here is Mr. Odumusu who teaches English... in our school',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'prontiation', 'is_correct' => false],
                    ['option' => 'prononciation', 'is_correct' => false],
                    ['option' => 'pronunciation', 'is_correct' => true],
                    ['option' => 'pronountiation', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct spelling for the word meaning the way in which a word is pronounced is "pronunciation".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'instead of... she lied',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'pleading', 'is_correct' => true],
                    ['option' => 'her to plead', 'is_correct' => false],
                    ['option' => 'her pleading', 'is_correct' => false],
                    ['option' => 'plead', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct form for the phrase meaning asking for something in a sincere and emotional way is "pleading".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Of the three girls, Uka is the....',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'so much notorious', 'is_correct' => false],
                    ['option' => 'notorious', 'is_correct' => false],
                    ['option' => 'naught', 'is_correct' => false],
                    ['option' => 'naughtiest', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word meaning the most badly behaved is "naughtiest".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'I wonder how he will ... being absent from school for a long time',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'make in', 'is_correct' => false],
                    ['option' => 'make up', 'is_correct' => false],
                    ['option' => 'make off', 'is_correct' => false],
                    ['option' => 'make out', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct phrasal verb meaning to deal with or manage is "make out".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Please sit on the...',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'carier', 'is_correct' => false],
                    ['option' => 'career', 'is_correct' => true],
                    ['option' => 'carrier', 'is_correct' => false],
                    ['option' => 'carrear', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word for the context meaning occupation or profession is "career".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'I want to ... his chance to acquaint you with the latest development',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'size', 'is_correct' => false],
                    ['option' => 'seize', 'is_correct' => true],
                    ['option' => 'sieze', 'is_correct' => false],
                    ['option' => 'cease', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word meaning to take hold of suddenly and forcibly is "seize".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Getting a well-paid job nowadays is on..... task',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'utmost', 'is_correct' => false],
                    ['option' => 'upbeat', 'is_correct' => false],
                    ['option' => 'uphill', 'is_correct' => true],
                    ['option' => 'upfield', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word meaning difficult or requiring great effort is "uphill".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The secretary has no right to ... my affairs',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'spy from', 'is_correct' => false],
                    ['option' => 'meddle in', 'is_correct' => true],
                    ['option' => 'toy at', 'is_correct' => false],
                    ['option' => 'complain into', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct phrase meaning to interfere is "meddle in".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Bola studiously avoided... the question',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'parrying', 'is_correct' => true],
                    ['option' => 'answering', 'is_correct' => false],
                    ['option' => 'projecting', 'is_correct' => false],
                    ['option' => 'destroying', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct word meaning to evade or avoid answering is "parrying".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The school authority dismissed him for .... But I won’t tell you about it yet',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'certain reason', 'is_correct' => false],
                    ['option' => 'a reason', 'is_correct' => false],
                    ['option' => 'more reason', 'is_correct' => false],
                    ['option' => 'a certain reason', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct phrase meaning a specific but unspecified reason is "a certain reason".',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],


            // ... additional questions
        ];

        $SameVowelSoundInstructionText = 'choose the option that has the same vowel sound as the one represented by the letter(s) underlined';
        $SameVowelSoundInstruction = QuestionInstruction::firstOrCreate(['instruction' => $SameVowelSoundInstructionText]);

        $SameVowelSoundQuestions = [
            [
                'question' => 'bu<u>b</u>ble',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'guy', 'is_correct' => false],
                    ['option' => 'bull', 'is_correct' => true],
                    ['option' => 'bumper', 'is_correct' => false],
                    ['option' => 'gurgle', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "bubble" matches the vowel sound in "bull".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
            [
                'question' => 'W<u>ei</u>ght',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'whale', 'is_correct' => false],
                    ['option' => 'while', 'is_correct' => true],
                    ['option' => 'wheat', 'is_correct' => false],
                    ['option' => 'writhe', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "weight" matches the vowel sound in "while".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
            [
                'question' => 'L<u>ea</u>ch',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'gear', 'is_correct' => false],
                    ['option' => 'cedar', 'is_correct' => false],
                    ['option' => 'cheer', 'is_correct' => true],
                    ['option' => 'death', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "leach" matches the vowel sound in "cheer".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
        ];

        $SameConsonantSoundInstructionText = 'choose the option that has the consonant sound as the one represented by the letter(s) underlined';
        $SameConsonantSoundInstruction = QuestionInstruction::firstOrCreate(['instruction' => $SameConsonantSoundInstructionText]);

        $SameConsonantSoundQuestions = [
            [
                'question' => 'Me<u>nt</u>ion',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'that', 'is_correct' => false],
                    ['option' => 'machine', 'is_correct' => false],
                    ['option' => 'church', 'is_correct' => false],
                    ['option' => 'test', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound in "mention" matches the consonant sound in "test".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
            [
                'question' => 'Pres<u>t</u>ige',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'bag', 'is_correct' => false],
                    ['option' => 'badge', 'is_correct' => true],
                    ['option' => 'reggae', 'is_correct' => false],
                    ['option' => 'leisure', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound in "prestige" matches the consonant sound in "badge".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
            [
                'question' => 'K<u>n</u>ot',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'cot', 'is_correct' => false],
                    ['option' => 'keep', 'is_correct' => false],
                    ['option' => 'norm', 'is_correct' => true],
                    ['option' => 'king', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound in "knot" matches the consonant sound in "norm".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
        ];

        $RhymingWordsInstructionText = 'choose the option that rhymes with the given word';
        $RhymingWordsInstruction = QuestionInstruction::firstOrCreate(['instruction' => $RhymingWordsInstructionText]);

        $RhymingWordsQuestions = [
            [
                'question' => 'Fuel',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'cruel', 'is_correct' => false],
                    ['option' => 'fool', 'is_correct' => false],
                    ['option' => 'rule', 'is_correct' => true],
                    ['option' => 'field', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "rule" rhymes with "fuel".',
                'question_instruction_id' => $RhymingWordsInstruction->id,
            ],
            [
                'question' => 'Match',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'harsh', 'is_correct' => false],
                    ['option' => 'batch', 'is_correct' => true],
                    ['option' => 'such', 'is_correct' => false],
                    ['option' => 'watch', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "batch" rhymes with "match".',
                'question_instruction_id' => $RhymingWordsInstruction->id,
            ],
            [
                'question' => 'Sheer',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Sheila', 'is_correct' => false],
                    ['option' => 'care', 'is_correct' => false],
                    ['option' => 'ear', 'is_correct' => true],
                    ['option' => 'sherry', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "ear" rhymes with "sheer".',
                'question_instruction_id' => $RhymingWordsInstruction->id,
            ],
        ];

        $StressPatternInstructionText = 'choose the appropriate stress pattern from the option. The syllables are written in capital letters.';
        $StressPatternInstruction = QuestionInstruction::firstOrCreate(['instruction' => $StressPatternInstructionText]);

        $StressPatternQuestions = [
            [
                'question' => 'Termination',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'terminaTION', 'is_correct' => true],
                    ['option' => 'TERmination', 'is_correct' => false],
                    ['option' => 'termiNAtion', 'is_correct' => false],
                    ['option' => 'terMINation', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "terminaTION".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
            [
                'question' => 'meditative',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'meDItative', 'is_correct' => true],
                    ['option' => 'mediTAtive', 'is_correct' => false],
                    ['option' => 'Meditative', 'is_correct' => false],
                    ['option' => 'meditaTIVE', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "meDItative".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
            [
                'question' => 'Suggestible',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'suggeSTIble', 'is_correct' => false],
                    ['option' => 'Suggestible', 'is_correct' => true],
                    ['option' => 'suGGEStible', 'is_correct' => false],
                    ['option' => 'suggestible', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "Suggestible".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
        ];

        $EmphaticStressInstructionText = 'choose the option to which the given sentence relates';
        $EmphaticStressInstruction = QuestionInstruction::firstOrCreate(['instruction' => $EmphaticStressInstructionText]);

        $EmphaticStressQuestions = [
            [
                'question' => 'Uche LOVES Toyota cars',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'who loves Toyota cars?', 'is_correct' => false],
                    ['option' => 'What brand of car does Uche love?', 'is_correct' => true],
                    ['option' => 'Does Uche hate Toyota cars?', 'is_correct' => false],
                    ['option' => 'Dose Uche love bicycles?', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct option that emphasizes the word "loves" is "What brand of car does Uche love?".',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
            [
                'question' => 'The POLICE arrested the suspect',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Did the police placate the suspect?', 'is_correct' => false],
                    ['option' => 'Who arrested the suspect?', 'is_correct' => true],
                    ['option' => 'Who did the police arrest?', 'is_correct' => false],
                    ['option' => 'Did the police arrest the suspect?', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct option that emphasizes the word "police" is "Who arrested the suspect?".',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
            [
                'question' => 'Maiduguri is the CAPITAL of Borno state',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Is Maiduguri the capital of plateau state?', 'is_correct' => false],
                    ['option' => 'Which state is Maiduguri the capital of?', 'is_correct' => true],
                    ['option' => 'Is Maiduguri a town in Borno state?', 'is_correct' => false],
                    ['option' => 'What is the capital of Borno state?', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct option that emphasizes the word "capital" is "Which state is Maiduguri the capital of?".',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
        ];

        $ExplanationInstructionText = 'select the option that best explains the information conveyed in the sentence. Each question carries 2 marks';
        $ExplanationInstruction = QuestionInstruction::firstOrCreate(['instruction' => $ExplanationInstructionText]);

        $ExplanationQuestions = [
            [
                'question' => 'Hardworking students must not have a finger in very pie at school.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Hardworking students must not have a role to play in most activities in the school', 'is_correct' => true],
                    ['option' => 'Only hardworking students must participate in all activities in the school', 'is_correct' => false],
                    ['option' => 'Hardworking students do not participate in all activities in the school', 'is_correct' => false],
                    ['option' => 'Hardworking students must ask others to participate in school activities', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation for "not having a finger in every pie" means not being involved in many activities.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'The vice chancellor is riding the crest of the last quarter of his administration.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'The vice chancellor enjoys the acknowledgement of the success of his administration', 'is_correct' => true],
                    ['option' => 'The vice chancellor does not enjoy the people’s criticism of his administration', 'is_correct' => false],
                    ['option' => 'The vice chancellor hopes to overcome soon, the poor comments on his administration', 'is_correct' => false],
                    ['option' => 'The vice chancellor does not talk of his successes on office', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation for "riding the crest" means enjoying a period of success.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'She was absolved by the course from the charge.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'She was convicted for the charge', 'is_correct' => false],
                    ['option' => 'She was blamed and charged to court', 'is_correct' => false],
                    ['option' => 'Her case was resolved by the court', 'is_correct' => false],
                    ['option' => 'She was declared free from the charge', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation for "absolved from the charge" means declared free from the charge.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'The landlord is fond of throwing his weight about.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'The landlord likes healthy exercise', 'is_correct' => false],
                    ['option' => 'The landlord is overweight', 'is_correct' => false],
                    ['option' => 'The landlord gives orders to people', 'is_correct' => true],
                    ['option' => 'The landlord is respected by his tenants', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation for "throwing his weight about" means giving orders to people.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'The company ought to have issued warrants for one billion shares.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    [
                        'option' => 'The company has issued one billion shares', 'is_correct' => false
                    ],
                    ['option' => 'The management expected the company to issue more than one billion shares', 'is_correct' => false],
                    ['option' => 'Members of the company bought less than one billion shares', 'is_correct' => false],
                    ['option' => 'The company did not issue one billion shares', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation is that the company did not issue one billion shares.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'He needed not to have played in the position of quarterback in the volleyball.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'He participated in the game in his unusual position', 'is_correct' => false],
                    ['option' => 'Nobody expected him to have participated in the game', 'is_correct' => true],
                    ['option' => 'He wanted to play in a position other than the one he was offered', 'is_correct' => false],
                    ['option' => 'Someone did not want him to play in the position that he played', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation is that nobody expected him to have participated in the game.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'I wouldn’t have responded to his rude talk, if I were you.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'The advice was taken by the respondent, so he did not respond to the talk', 'is_correct' => false],
                    ['option' => 'The adviser put himself in the respondent’s position, so he did not respond to the talk', 'is_correct' => false],
                    ['option' => 'The respondent replied to the speaker’s talk, although he ought not to have done so', 'is_correct' => true],
                    ['option' => 'What was advisable was that the respondent gave it back to the speaker', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation is that the respondent replied to the speaker’s talk, although he ought not to have done so.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'He could not speak out because he had a feet of clay.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    [
                        'option' => 'His feet was muddy', 'is_correct' => false
                    ],
                    ['option' => 'He was weak and cowardly', 'is_correct' => true],
                    ['option' => 'He was shy and timid', 'is_correct' => false],
                    ['option' => 'He was clumsy and lazy', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation for "feet of clay" means being weak and cowardly.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'The player wasted a golden opportunity during the penalty shoot-out.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'The player first the bar', 'is_correct' => false],
                    ['option' => 'The player did not score the shot', 'is_correct' => true],
                    ['option' => 'The player scored the shot that made them win the gold cup', 'is_correct' => false],
                    ['option' => 'Instead of a silver cup, they received the golden one', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation is that the player did not score the shot.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],
            [
                'question' => 'As far as Abu is concerned, Mero should be given fifty naira at the most',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'All Abu is saying is that Mero probably deserves more than fifty naira and not less', 'is_correct' => false],
                    ['option' => 'All Abu is concerned with is that Mero should be given nothing more than fifty naira', 'is_correct' => true],
                    ['option' => 'In Abu’s estimation, Mero merits not more than fifty naira', 'is_correct' => false],
                    ['option' => 'In Abu’s opinion, Mero deserves fifty naira or probably more', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct explanation is that Mero should be given nothing more than fifty naira.',
                'question_instruction_id' => $ExplanationInstruction->id,
            ],


        ];

        $OppositeMeaningInstructionText = 'choose the option opposite in meaning to the word or phrase in italics';
        $OppositeMeaningInstruction = QuestionInstruction::firstOrCreate(['instruction' => $OppositeMeaningInstructionText]);

        $OppositeMeaningQuestions = [
            [
                'question' => 'As an idiot, the boy is <i>weak</i> in class.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'a deviant', 'is_correct' => false],
                    ['option' => 'a dunce', 'is_correct' => false],
                    ['option' => 'an expert', 'is_correct' => false],
                    ['option' => 'a genius', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "weak" in the context of class performance is "a genius".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'We were <i>shocked</i> by the news that he had lost the money.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'astonished', 'is_correct' => false],
                    ['option' => 'disconcerted', 'is_correct' => false],
                    ['option' => 'unconcerned', 'is_correct' => true],
                    ['option' => 'surprised', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "shocked" in this context is "unconcerned".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'The principal was advised to be <i>flexible</i> on critical issues.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'livid', 'is_correct' => false],
                    ['option' => 'cautious', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "flexible" in this context is "rigid".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Bola always looks <i>sober</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'excited', 'is_correct' => true],
                    ['option' => 'serious', 'is_correct' => false],
                    ['option' => 'worried', 'is_correct' => false],
                    ['option' => 'helpless', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "sober" in this context is "excited".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Dupe was promoted for her <i>efficiency</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'ability', 'is_correct' => false],
                    ['option' => 'incompetence', 'is_correct' => true],
                    ['option' => 'inconsistency', 'is_correct' => false],
                    ['option' => 'rudeness', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "efficiency" is "incompetence".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'The management wants to consider her <i>reticent</i> behaviour in due course.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'disapproving', 'is_correct' => false],
                    ['option' => 'disciplinarian', 'is_correct' => false],
                    ['option' => 'contemplative', 'is_correct' => false],
                    ['option' => 'loquacious', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "reticent" is "loquacious".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Election process often become <i>volatile</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'calm', 'is_correct' => true],
                    ['option' => 'strange', 'is_correct' => false],
                    ['option' => 'sudden', 'is_correct' => false],
                    ['option' => 'latent', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "volatile" is "calm".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Oche entered the principal’s office in a rather <i>abrasive</i> manner.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'gentle', 'is_correct' => true],
                    ['option' => 'rude', 'is_correct' => false],
                    ['option' => 'lackadaisical', 'is_correct' => false],
                    ['option' => 'indifferent', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "abrasive" is "gentle".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Otokpa is a member of the <i>ad hoc</i> committee on stock acquisition.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'improvised', 'is_correct' => false],
                    ['option' => 'formal', 'is_correct' => false],
                    ['option' => 'temporary', 'is_correct' => true],
                    ['option' => 'fact-finding', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "ad hoc" is "formal".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'His gift to the poor was always <i>infinitesimal</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'large', 'is_correct' => true],
                    ['option' => 'small', 'is_correct' => false],
                    ['option' => 'supportive', 'is_correct' => false],
                    ['option' => 'shameful', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "infinitesimal" is "large".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],

            [
                'question' => 'The economist concluded that several factors have been <i>adduced</i> to explain the fall in the birth rate.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'affirmed', 'is_correct' => false],
                    ['option' => 'diffused', 'is_correct' => false],
                    ['option' => 'mentioned', 'is_correct' => false],
                    ['option' => 'refuted', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "adduced" (presented or brought forward) is "refuted".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'The presidential system is an <i>antidote</i> to some political ailments.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'an answer', 'is_correct' => false],
                    ['option' => 'a reply', 'is_correct' => false],
                    ['option' => 'an injury', 'is_correct' => true],
                    ['option' => 'an obstacle', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "antidote" (a remedy) is "an injury".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'Ola thought that her father was very <i>callous</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'parlous', 'is_correct' => false],
                    ['option' => 'compassionate', 'is_correct' => true],
                    ['option' => 'wicked', 'is_correct' => false],
                    ['option' => 'cheerful', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "callous" (emotionally hardened) is "compassionate".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'He was very much respected, though he had no <i>temporal</i> power.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'spiritual', 'is_correct' => true],
                    ['option' => 'mundane', 'is_correct' => false],
                    ['option' => 'permanent', 'is_correct' => false],
                    ['option' => 'ephemeral', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "temporal" (worldly) is "spiritual".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ],
            [
                'question' => 'The way the worship was organized was rather <i>hit-and-miss</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'systematic', 'is_correct' => true],
                    ['option' => 'hasty', 'is_correct' => false],
                    ['option' => 'slow', 'is_correct' => false],
                    ['option' => 'funny', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The opposite of "hit-and-miss" (random or sporadic) is "systematic".',
                'question_instruction_id' => $OppositeMeaningInstruction->id,
            ]
        ];

        $NearestInMeaningInstructionText = 'choose the option nearest in meaning to the word or phrase in italics';
        $NearestInMeaningInstruction = QuestionInstruction::firstOrCreate(['instruction' => $NearestInMeaningInstructionText]);

        $NearestInMeaningQuestionstwo = [
            [
                'question' => 'Some men will continue to cause offences until they are given a taste of their own <i>medicine</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'placated', 'is_correct' => false],
                    ['option' => 'revenged on', 'is_correct' => true],
                    ['option' => 'recompensed for', 'is_correct' => false],
                    ['option' => 'cured', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The phrase "a taste of their own medicine" means to be treated in the same negative way one has been treating others.',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'Okibe was rusticated for his <i>derogated</i> remark about the principal.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'complimentary', 'is_correct' => true],
                    ['option' => 'unsavoury', 'is_correct' => false],
                    ['option' => 'unwarranted', 'is_correct' => false],
                    ['option' => 'lacklustre', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "derogated" means to make a remark that belittles or diminishes, so its opposite is "complimentary".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'Justice is difficult to enforce because people are unwilling to accept any loss of <i>sovereignty</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'autonomy', 'is_correct' => true],
                    ['option' => 'position', 'is_correct' => false],
                    ['option' => 'leadership', 'is_correct' => false],
                    ['option' => 'kingdom', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "sovereignty" means supreme power or authority, which is closest in meaning to "autonomy".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'There are still <i>virtuous</i> women in our society today.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'clever', 'is_correct' => false],
                    ['option' => 'upright', 'is_correct' => true],
                    ['option' => 'devilish', 'is_correct' => false],
                    ['option' => 'intelligent', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "virtuous" means having high moral standards, which is closest in meaning to "upright".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'The type of response is <i>typical</i> of a lazy teacher.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'symptomatic', 'is_correct' => false],
                    ['option' => 'characteristic', 'is_correct' => true],
                    ['option' => 'universal', 'is_correct' => false],
                    ['option' => 'incontestable', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "typical" means having the distinctive qualities of a particular type of person or thing, which is closest in meaning to "characteristic".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'Akin is an <i>inveterate</i> gambler.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'a selfish and self-centred', 'is_correct' => false],
                    ['option' => 'an extremely unlucky but popular', 'is_correct' => false],
                    ['option' => 'an incurable but fearful', 'is_correct' => false],
                    ['option' => 'a long time and incorrigible', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "inveterate" means having a particular habit, activity, or interest that is long-established and unlikely to change, which is closest in meaning to "a long time and incorrigible".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'He was too <i>petrified</i> to give the closing remarks at the conference.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'frightened', 'is_correct' => true],
                    ['option' => 'delighted', 'is_correct' => false],
                    ['option' => 'agitated', 'is_correct' => false],
                    ['option' => 'happy', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "petrified" means so frightened that one is unable to move, which is closest in meaning to "frightened".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],

            [
                'question' => 'During a particular time of the day, the road <i>shimmers</i> in the heat.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'darkens', 'is_correct' => false],
                    ['option' => 'lightens', 'is_correct' => false],
                    ['option' => 'shines', 'is_correct' => true],
                    ['option' => 'beams', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "shimmers" means to shine with a soft tremulous light, which is closest in meaning to "shines".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'Every human being is <i>vulnerable</i> to communicable diseases.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'liable', 'is_correct' => true],
                    ['option' => 'lifted', 'is_correct' => false],
                    ['option' => 'immuned', 'is_correct' => false],
                    ['option' => 'closed', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "vulnerable" means susceptible to physical or emotional attack or harm, which is closest in meaning to "liable".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'Mariam looks rather <i>furtive</i> to Shehu.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'intoxicated', 'is_correct' => false],
                    ['option' => 'unfriendly', 'is_correct' => false],
                    ['option' => 'sad', 'is_correct' => false],
                    ['option' => 'sly', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "furtive" means attempting to avoid notice or attention, typically because of guilt or a belief that discovery would lead to trouble, which is closest in meaning to "sly".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'The student’s union leader delivered his speech <i>extempore</i>.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'out-of-hand', 'is_correct' => false],
                    ['option' => 'off the cuff', 'is_correct' => true],
                    ['option' => 'accurately', 'is_correct' => false],
                    ['option' => 'courageously', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "extempore" means spoken or done without preparation, which is closest in meaning to "off the cuff".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'His story gave us an <i>inkling</i> of what he passed through during the strike.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'a possible idea', 'is_correct' => false],
                    ['option' => 'a taste', 'is_correct' => true],
                    ['option' => 'a summary', 'is_correct' => false],
                    ['option' => 'the right view', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "inkling" means a slight knowledge or suspicion; a hint, which is closest in meaning to "a taste".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'These policies have been <i>espoused</i> by the ruling party.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'condemned', 'is_correct' => false],
                    ['option' => 'rejected', 'is_correct' => false],
                    ['option' => 'supported', 'is_correct' => true],
                    ['option' => 'outlined', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "espoused" means to adopt or support, which is closest in meaning to "supported".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ],
            [
                'question' => 'We must not <i>foreclose</i> reconciliation as the purpose of his trip.',
                'year' => 2012,
                'marks' => 1,
                'options' => [
                    ['option' => 'exclude', 'is_correct' => true],
                    ['option' => 'consider', 'is_correct' => false],
                    ['option' => 'underestimate', 'is_correct' => false],
                    ['option' => 'forgo', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The word "foreclose" means to rule out or exclude, which is closest in meaning to "exclude".',
                'question_instruction_id' => $NearestInMeaningInstruction->id,
            ]
        ];

        $GapFillingInstructionText = 'choose the option that best complete the gap(s)';
        $GapFillingInstruction = QuestionInstruction::firstOrCreate(['instruction' => $GapFillingInstructionText]);

        $GapFillingQuestionstwo = [
            [
                'question' => 'He was both a writer and a politician, but he was better___',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'as if', 'is_correct' => false],
                    ['option' => 'like', 'is_correct' => false],
                    ['option' => 'as', 'is_correct' => true],
                    ['option' => 'to be', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "as", which correctly completes the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Vacancies in the company will be notified by ___',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'bulletin', 'is_correct' => true],
                    ['option' => 'publication', 'is_correct' => false],
                    ['option' => 'publicity', 'is_correct' => false],
                    ['option' => 'advertisement', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "bulletin", which is the appropriate term for notifying vacancies.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The driver was short of petrol, so he ____',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'glided', 'is_correct' => false],
                    ['option' => 'coasted', 'is_correct' => true],
                    ['option' => 'wheeled', 'is_correct' => false],
                    ['option' => 'taxied', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "coasted", which means moving without power or effort.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'He started his career as an ____ teacher.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'auxillary', 'is_correct' => false],
                    ['option' => 'auxilliary', 'is_correct' => false],
                    ['option' => 'auxiliary', 'is_correct' => true],
                    ['option' => 'auxilary', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "auxiliary", which is the correct spelling.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'His many years of success in legal practice, __ didn’t come without challenges.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'indeed', 'is_correct' => false],
                    ['option' => 'but', 'is_correct' => false],
                    ['option' => 'in spite of it all', 'is_correct' => false],
                    ['option' => 'however', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "however", which properly contrasts the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'One should be careful how___behaves in the public, shouldn’t ___?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'one/one', 'is_correct' => true],
                    ['option' => 'he/he', 'is_correct' => false],
                    ['option' => 'she/one', 'is_correct' => false],
                    ['option' => 'one/he', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "one/one", which maintains consistency in the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => '___, a good leader must have two characteristics.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'First and formost', 'is_correct' => false],
                    ['option' => 'First and formost', 'is_correct' => false],
                    ['option' => 'First and foremost', 'is_correct' => true],
                    ['option' => 'First and foremost', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "First and foremost", which is the correct spelling.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'We visited his house___ three times.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'like', 'is_correct' => false],
                    ['option' => 'for', 'is_correct' => true],
                    ['option' => 'about', 'is_correct' => false],
                    ['option' => 'for about', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "for", which properly completes the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'She was___ the verge of tears.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' at', 'is_correct' => true],
                    ['option' => ' on', 'is_correct' => false],
                    ['option' => ' by', 'is_correct' => false],
                    ['option' => 'with', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "at", which is the correct preposition to use in this context.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Everyone makes mistakes occasionally; nobody is___',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' incorrigible', 'is_correct' => false],
                    ['option' => ' Imperfect', 'is_correct' => false],
                    ['option' => ' Infallible', 'is_correct' => true],
                    ['option' => 'indestructible', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "infallible", which means incapable of making mistakes or being wrong.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The woman would not part with her___ pot.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' discarded earthen black ', 'is_correct' => false],
                    ['option' => ' discarded black earthen C.', 'is_correct' => false],
                    ['option' => ' earthen discarded black D.', 'is_correct' => false],
                    ['option' => 'black earthen discarded', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "black earthen discarded", which properly describes the pot.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'We stood up when the principal came in___',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' isn’t it', 'is_correct' => false],
                    ['option' => ' didn’t we', 'is_correct' => true],
                    ['option' => ' not so', 'is_correct' => false],
                    ['option' => 'did us', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "didn’t we", which is the correct tag question.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The professor of___ medicine has___ the mystery of flu.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' vetinary / unraveled', 'is_correct' => false],
                    ['option' => ' vertrinay / unravelled', 'is_correct' => false],
                    ['option' => ' veterinary / unraveled', 'is_correct' => true],
                    ['option' => 'veterinary / unravelled', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "veterinary / unraveled", which are the correct spellings.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Her mother brought her some___',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' clothes', 'is_correct' => true],
                    ['option' => ' yards', 'is_correct' => false],
                    ['option' => ' cloth', 'is_correct' => false],
                    ['option' => 'clothing', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "clothes", which fits the context of the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'Many workers were___ as a result of the textile closure.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' laid down', 'is_correct' => false],
                    ['option' => ' laid off', 'is_correct' => true],
                    ['option' => ' laid out', 'is_correct' => false],
                    ['option' => 'laid up', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "laid off", which means dismissed from work.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'The driver died in the___ road accident.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' fatal', 'is_correct' => true],
                    ['option' => ' brutal', 'is_correct' => false],
                    ['option' => ' serious', 'is_correct' => false],
                    ['option' => 'pathetic', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "fatal", which means causing death.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => '___ your parents frown___ our friendship, we shouldn’t see each other anymore.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' Because / over', 'is_correct' => false],
                    ['option' => ' Since / at', 'is_correct' => false],
                    ['option' => ' Although /at', 'is_correct' => false],
                    ['option' => 'As / upon', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "As / upon", which fits the context of the sentence.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
            [
                'question' => 'For more productivity, the company is focusing attention on the possible___ of available resources.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' synergy', 'is_correct' => true],
                    ['option' => ' tapping', 'is_correct' => false],
                    ['option' => ' alignment', 'is_correct' => false],
                    ['option' => 'arrangement', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct answer is "synergy", which means the interaction or cooperation of two or more organizations to produce a combined effect.',
                'question_instruction_id' => $GapFillingInstruction->id,
            ],
        ];

        $SameVowelSoundInstructionText = 'choose the option that has the same vowel sound as the one represented by the letter(s) underlined';
        $SameVowelSoundInstruction = QuestionInstruction::firstOrCreate(['instruction' => $SameVowelSoundInstructionText]);

        $SameVowelSoundQuestionstwo = [
            [
                'question' => 'bo<u>o</u>k',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' cool', 'is_correct' => false],
                    ['option' => ' cook', 'is_correct' => true],
                    ['option' => ' fool', 'is_correct' => false],
                    ['option' => 'tool', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "book" matches the vowel sound in "cook".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
            [
                'question' => 'vill<u>a</u>ge',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' page', 'is_correct' => false],
                    ['option' => ' pig', 'is_correct' => true],
                    ['option' => ' made', 'is_correct' => false],
                    ['option' => 'came', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "village" matches the vowel sound in "pig".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
            [
                'question' => 'pat<u>a</u>ch',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' starch', 'is_correct' => true],
                    ['option' => ' fare', 'is_correct' => false],
                    ['option' => ' mad', 'is_correct' => false],
                    ['option' => 'brave', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The vowel sound in "patch" matches the vowel sound in "starch".',
                'question_instruction_id' => $SameVowelSoundInstruction->id,
            ],
        ];

        $SameConsonantSoundInstructionText = 'choose the option that has the same consonant sound as the one represented by the letter(s) underlined';
        $SameConsonantSoundInstruction = QuestionInstruction::firstOrCreate(['instruction' => $SameConsonantSoundInstructionText]);

        $SameConsonantSoundQuestionstwo = [
            [
                'question' => 'tang<u>er</u>ine',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' gear', 'is_correct' => false],
                    ['option' => ' danger', 'is_correct' => true],
                    ['option' => ' girl', 'is_correct' => false],
                    ['option' => 'ignore', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound "er" in "tangerine" matches the sound in "danger".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
            [
                'question' => 'h<u>air</u>',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' heir', 'is_correct' => true],
                    ['option' => ' hour', 'is_correct' => false],
                    ['option' => ' honest', 'is_correct' => false],
                    ['option' => 'house', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound "air" in "hair" matches the sound in "heir".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
            [
                'question' => 'edit<u>ion</u>',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => ' bash', 'is_correct' => false],
                    ['option' => ' catch', 'is_correct' => false],
                    ['option' => ' bastion', 'is_correct' => true],
                    ['option' => 'rating', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The consonant sound "ion" in "edition" matches the sound in "bastion".',
                'question_instruction_id' => $SameConsonantSoundInstruction->id,
            ],
        ];

        $StressPatternInstructionText = 'choose the appropriate stress pattern from the options. The syllables are written in capital letters';
        $StressPatternInstruction = QuestionInstruction::firstOrCreate(['instruction' => $StressPatternInstructionText]);

        $StressPatternQuestions = [
            [
                'question' => 'demarcation',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Word Stress (Monosyllabic and Polysyllabic)',
                'options' => [
                    ['option' => ' demarCAtion', 'is_correct' => true],
                    ['option' => ' DEMarcation', 'is_correct' => false],
                    ['option' => ' demarcaTION', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "demarCAtion".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
            [
                'question' => 'impossible',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Word Stress (Monosyllabic and Polysyllabic)',
                'options' => [
                    ['option' => ' imPOSible', 'is_correct' => false],
                    ['option' => ' IMPosible', 'is_correct' => false],
                    ['option' => ' imposSIble', 'is_correct' => false],
                    ['option' => 'impossiBLE', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "impossiBLE".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
            [
                'question' => 'imperialism',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Word Stress (Monosyllabic and Polysyllabic)',
                'options' => [
                    ['option' => ' IMperialism', 'is_correct' => false],
                    ['option' => ' imPErialism', 'is_correct' => false],
                    ['option' => ' impeRIAlism', 'is_correct' => true],
                    ['option' => 'imperialISM', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The correct stress pattern is "impeRIAlism".',
                'question_instruction_id' => $StressPatternInstruction->id,
            ],
        ];

        $EmphaticStressInstructionText = 'Choose the option to which the given sentence with emphatic stress in capital letters relates.';
        $EmphaticStressInstruction = QuestionInstruction::firstOrCreate(['instruction' => $EmphaticStressInstructionText]);

        $EmphaticStressQuestionstwo = [
            [
                'question' => 'The traditional chief NARRATED the story to the children.',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Intonation Patterns',
                'options' => [
                    ['option' => ' The children heard the story from the traditional chief', 'is_correct' => false],
                    ['option' => ' Who narrated the story to the children?', 'is_correct' => true],
                    ['option' => ' The children could not listen to the story by the traditional chief', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The emphatic stress on "NARRATED" prompts a focus on who performed the action, making option B correct.',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
            [
                'question' => 'The ACCOUNTANT paid the workers’ July salary in September.',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Intonation Patterns',
                'options' => [
                    ['option' => ' When were the workers paid', 'is_correct' => false],
                    ['option' => ' Did the cashier pay the workers’ salary in September', 'is_correct' => false],
                    ['option' => ' Workers received their July salary in September', 'is_correct' => true],
                    ['option' => 'The September salary was paid in July', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The stress on "ACCOUNTANT" indicates who performed the action, but option C, which clarifies when the salary was received, directly relates to the timing emphasized in the question.',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
            [
                'question' => 'The cat DEVOURED the rat.',
                'year' => 2012,
                'marks' => 2,
                'topic' => 'Intonation Patterns',
                'options' => [
                    ['option' => ' Did the rat devoured the cat?', 'is_correct' => false],
                    ['option' => ' What devoured the rat?', 'is_correct' => false],
                    ['option' => ' Did the cat pet the rat?', 'is_correct' => false],
                    ['option' => 'Is this the rat the cat devoured?', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The stress on "DEVOURED" suggests a question about the act described, making option D correct as it confirms the action taken on the rat.',
                'question_instruction_id' => $EmphaticStressInstruction->id,
            ],
        ];


        $LexisStructureInstructionText = 'Select the option that best explains the information conveyed in the sentence.';
        $LexisStructureInstruction = QuestionInstruction::firstOrCreate(['instruction' => $LexisStructureInstructionText]);

        $LexisStructureQuestions = [
            [
                'question' => 'The team’s poor performance at the tournament plumbed the depths of horror.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' The team’s performance took them to the next round', 'is_correct' => false],
                    ['option' => ' The team’s performance was enjoyed by all', 'is_correct' => false],
                    ['option' => ' The team’s performance was full of disappointment', 'is_correct' => true],
                    ['option' => 'The team’s performance was rewarded', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The phrase "plumbed the depths of horror" suggests a profound level of failure or disappointment, making option C the correct explanation.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'Tolu and Chinedu live in each other’s pockets.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' They are long-term business partners', 'is_correct' => false],
                    ['option' => ' They steal from each other', 'is_correct' => false],
                    ['option' => ' They blackmail each other', 'is_correct' => false],
                    ['option' => 'They are very close to each other', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => 'The idiom "live in each other’s pockets" means to be very close to each other, often spending a great deal of time together, hence option D is correct.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'As the drama unfolded, Olatunuke was advised',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' She was advised to wear her shirt', 'is_correct' => false],
                    ['option' => ' She was advised to commit herself', 'is_correct' => false],
                    ['option' => ' She was advised to stay calm', 'is_correct' => true],
                    ['option' => 'She was advised to join the club', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'In the context of unfolding drama, being advised to "stay calm" (option C) is the most logical and relevant advice.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'Zinana’s examination result was not unfavorable.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' She failed her examination', 'is_correct' => false],
                    ['option' => ' Her examination did not meet her expectation', 'is_correct' => false],
                    ['option' => ' She was successful in the examination', 'is_correct' => true],
                    ['option' => 'Her result could not earn her admission', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'The term "not unfavorable" implies that the results were actually good, making option C the correct explanation that she was successful in the examination.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],

            [
                'question' => 'You need to brush up on your Spanish.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' You need to study the history of Spain', 'is_correct' => false],
                    ['option' => ' You need to improve your skills', 'is_correct' => true],
                    ['option' => ' You need a brush from Spain', 'is_correct' => false],
                    ['option' => 'You need to learn to play with a Spaniard.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'To "brush up" on something means to improve skills in a specific area, making option B correct.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'Amaka would pass for a beauty queen.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' She would pass the drink to the queen who is sitting next to her.', 'is_correct' => false],
                    ['option' => ' She would be accepted by all as a beauty queen.', 'is_correct' => true],
                    ['option' => ' She walked past the beauty queen.', 'is_correct' => false],
                    ['option' => 'She was acting as a beauty queen.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Would pass for" suggests that she could be mistaken or accepted as a beauty queen, making option B correct.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => '"I can’t wait to become a mother," the new bride declared.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' She sees motherhood as a burden', 'is_correct' => false],
                    ['option' => ' She is excited about motherhood', 'is_correct' => true],
                    ['option' => ' She is not keen on becoming a mother', 'is_correct' => false],
                    ['option' => 'She will be patient as a mother.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Saying "I can’t wait" indicates enthusiasm and excitement, hence option B is correct.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'Usman needs to get his acts together if he wants to pass the examination.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' He needs to put all points down in the examination', 'is_correct' => false],
                    ['option' => ' He needs to organize himself.', 'is_correct' => true],
                    ['option' => ' He needs to be fast when writing the examination.', 'is_correct' => false],
                    ['option' => 'He needs to put on his stage costume.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'To "get his acts together" means to organize or prepare oneself properly, making option B the correct explanation.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ],
            [
                'question' => 'Ramatu expressed her feelings in no uncertain terms.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Clause and Sentence Patterns',
                'options' => [
                    ['option' => ' She expressed it dearly and strongly.', 'is_correct' => false],
                    ['option' => ' She expressed it secretly and courageously.', 'is_correct' => false],
                    ['option' => ' She expressed it quietly and cautiously.', 'is_correct' => false],
                    ['option' => 'She expressed it feebly and sickly.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => 'Expressing something "in no uncertain terms" means to do so clearly and definitively. None of the options directly reflect this, suggesting a potential error in the options provided.',
                'question_instruction_id' => $LexisStructureInstruction->id,
            ]
        ];

        $SynonymsAntonymsInstructionText = 'Choose the option opposite in meaning to the word or phrase in italics.';
        $SynonymsAntonymsInstruction = QuestionInstruction::firstOrCreate(['instruction' => $SynonymsAntonymsInstructionText]);

        $SynonymsAntonymsQuestions = [
            [
                'question' => 'The girl took a cursory glance at the letter and hid it.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Synonyms and Antonyms',
                'options' => [
                    ['option' => 'sententious', 'is_correct' => false],
                    ['option' => 'concise', 'is_correct' => false],
                    ['option' => 'brief', 'is_correct' => false],
                    ['option' => 'lasting', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'explanation' => '"Cursory" means quick and not thorough; "lasting" implies something long-term, making it the opposite.',
                'question_instruction_id' => $SynonymsAntonymsInstruction->id,
            ],
            [
                'question' => 'The relationship between the couple has been frosty.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Synonyms and Antonyms',
                'options' => [
                    ['option' => 'fraudulent', 'is_correct' => false],
                    ['option' => 'cordial', 'is_correct' => true],
                    ['option' => 'amenable', 'is_correct' => false],
                    ['option' => 'frugal', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Frosty" often describes a cold or unfriendly relationship, whereas "cordial" implies warmth and friendliness.',
                'question_instruction_id' => $SynonymsAntonymsInstruction->id,
            ],
            [
                'question' => 'The Nobel laureate’s activity in the field of science is heinous.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Synonyms and Antonyms',
                'options' => [
                    ['option' => 'indelible', 'is_correct' => false],
                    ['option' => 'laudable', 'is_correct' => true],
                    ['option' => 'deplorable', 'is_correct' => false],
                    ['option' => 'forgettable', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Heinous" means utterly odious or wicked, making "laudable" (praiseworthy) its opposite.',
                'question_instruction_id' => $SynonymsAntonymsInstruction->id,
            ],
            [
                'question' => 'Everyone’s condition was appalling.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Synonyms and Antonyms',
                'options' => [
                    ['option' => 'simple', 'is_correct' => false],
                    ['option' => 'cloudy', 'is_correct' => false],
                    ['option' => 'pleasant', 'is_correct' => true],
                    ['option' => 'complex', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Appalling" suggests something very bad or unpleasant, hence "pleasant" is the opposite.',
                'question_instruction_id' => $SynonymsAntonymsInstruction->id,
            ],
            [
                'question' => 'The man’s mordant wit is apparent to the entire village.',
                'year' => 2013,
                'marks' => 2,
                'topic' => 'Synonyms and Antonyms',
                'options' => [
                    ['option' => 'kind', 'is_correct' => false],
                    ['option' => 'scathing', 'is_correct' => false],
                    ['option' => 'caustic', 'is_correct' => true],
                    ['option' => 'withering', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'explanation' => '"Mordant" means sharply caustic or sarcastic, so the correct option emphasizing similar traits is "caustic."',
                'question_instruction_id' => $SynonymsAntonymsInstruction->id,
            ]
        ];



        $questions = array_merge(
            $OppInMeaningInstruction,
            $NearestInMeaningQuestions,
            $GapFillingQuestions,
            $SameVowelSoundQuestions,
            $SameConsonantSoundQuestions,
            $RhymingWordsQuestions,
            $StressPatternQuestions,
            $EmphaticStressQuestions,
            $ExplanationQuestions,
            $OppositeMeaningQuestions,
            $NearestInMeaningQuestionstwo,
            $GapFillingQuestionstwo,
            $SameConsonantSoundQuestionstwo,
            $SameVowelSoundQuestionstwo,
            $StressPatternQuestions,
            $EmphaticStressQuestionstwo,
            $LexisStructureQuestions,
            $SynonymsAntonymsQuestions,

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

            // Check if module and unit information is provided
            $module = $unit = null;
            if (isset($questionData['module']) && isset($questionData['unit'])) {
                // Create or find the module and unit if they are provided
                $module = Module::firstOrCreate(['name' => $questionData['module']]);
                $unit = Unit::firstOrCreate([
                    'name' => $questionData['unit'],
                    'module_id' => $module->id,
                ]);
            }

            // Find or create the topic
            // If module/unit is provided, link it. Otherwise, create a standalone topic.
            $topic = null;

            // If a topic name is provided, create or find the topic.
            if (!empty($questionData['topic'])) {
                // Find the highest order number for the current topicable_id and topicable_type
                $highestOrder = Topic::where('topicable_id', $useOfEnglish->id)
                    ->where('topicable_type', Subject::class)
                    ->max('order');

                $topicOrder = $highestOrder ? $highestOrder + 1 : 1; // If there are no topics yet, start with order 1.

                $topic = Topic::firstOrNew(
                    [
                        'name' => $questionData['topic'],
                    ],
                    [
                        'unit_id' => $unit->id ?? null,
                        'topicable_type' => Subject::class,
                        'topicable_id' => $useOfEnglish->id,

                    ]
                );
            }

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
