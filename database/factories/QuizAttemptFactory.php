<?php

namespace Database\Factories;

use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizAttempt>
 */
class QuizAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = QuizAttempt::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'quiz_id' => \App\Models\Quiz::factory(),
            'start_time' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'end_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'score' => $this->faker->numberBetween(0, 100),
        ];
    }
}
