<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use Illuminate\Database\Seeder;
use App\Models\CompositeQuizSession;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuizDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }
    
    public function run()
    {
      
        // Create 1000 users
        $users = User::factory(1000)->create();

        // Get any four subjects at random
        $subjects = Subject::inRandomOrder()->limit(4)->get();

        foreach ($users as $user) {
            // Create a composite session for each user
            $compositeSession = CompositeQuizSession::factory()->create([
                'user_id' => $user->id,
                'start_time' => now(),
                'end_time' => now()->addHours(2),
                'duration' => 120,
                'allowed_attempts' => 1,
                'completed' => true,
            ]);

            $totalScore = 0;

            foreach ($subjects as $subject) {
                // Create an individual quiz for each subject
                $quiz = Quiz::factory()->create([
                    'title' => "{$subject->name} Quiz",
                    'quizzable_type' => Subject::class,
                    'quizzable_id' => $subject->id,
                    'duration' => 30,
                    'total_marks' => 100,
                    'total_questions' => 10,
                    'max_attempts' => 1,
                ]);

                // Create a quiz attempt
                $quizAttempt = QuizAttempt::factory()->create([
                    'user_id' => $user->id,
                    'quiz_id' => $quiz->id,
                    'composite_quiz_session_id' => $compositeSession->id,
                    'start_time' => now(),
                    'end_time' => now()->addMinutes(30),
                    'score' => rand(0, $quiz->total_marks),
                ]);

                $totalScore += $quizAttempt->score;

                // Create questions and answers for the quiz
                for ($i = 0; $i < $quiz->total_questions; $i++) {
                    $question = Question::factory()->create([
                        'quiz_id' => $quiz->id,
                        'quizzable_type' => Subject::class,
                        'quizzable_id' => $subject->id,
                        'question' => $this->faker->sentence(),
                        'type' => 'mcq',
                        'answer_text' => $this->faker->word,
                        'marks' => 1,
                    ]);

                    // Create options for the question, marking one as correct
                    $options = Option::factory(rand(2, 5))->create([
                        'question_id' => $question->id,
                        'is_correct' => false, // Set all initially as incorrect
                    ]);

                    // Randomly choose one option to be correct
                    $correctOption = $options->random();
                    $correctOption->update(['is_correct' => true]);

                    // Generate answers for the quiz attempt, randomly choosing correct or incorrect
                    QuizAnswer::factory()->create([
                        'user_id' => $user->id,
                        'quiz_attempt_id' => $quizAttempt->id,
                        'question_id' => $question->id,
                        'option_id' => $correctOption->id,
                        'correct' => $correctOption->is_correct,
                    ]);
                }
            }

            // Update the composite session total score after all attempts
            $compositeSession->update(['total_score' => $totalScore]);
        }
    }
}
