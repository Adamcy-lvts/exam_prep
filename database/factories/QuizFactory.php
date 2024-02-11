<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Quiz::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'duration' => $this->faker->numberBetween(10, 60), // Duration in minutes
            'total_marks' => $this->faker->numberBetween(50, 100),
            'total_questions' => $this->faker->numberBetween(10, 50),
            'max_attempts' => $this->faker->numberBetween(1, 3),
            'additional_config' => json_encode(['time_limit' => $this->faker->numberBetween(1, 3) * 30]),
        ];
    }
}
