<?php

namespace Database\Factories;

use App\Models\QuizAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizAnswer>
 */
class QuizAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = QuizAnswer::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'quiz_attempt_id' => \App\Models\QuizAttempt::factory(),
            'question_id' => \App\Models\Question::factory(),
            'option_id' => \App\Models\Option::factory(),
            'correct' => $this->faker->boolean(50), // 50% chance of being correct
            'answer_text' => $this->faker->text(200),
            'completed' => $this->faker->boolean(90), // 90% chance of being completed
        ];
    }
}
