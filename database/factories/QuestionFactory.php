<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Question::class;

    public function definition()
    {
        return [
            'quiz_id' => \App\Models\Quiz::factory(),
            'quizzable_type' => 'App\Models\Subject',
            'quizzable_id' => \App\Models\Subject::factory(),
            'question' => $this->faker->sentence(10),
            'type' => $this->faker->randomElement(['mcq', 'saq', 'tf']),
            'answer_text' => $this->faker->sentence(10),
            'question_image' => $this->faker->imageUrl(),
            'marks' => $this->faker->numberBetween(1, 5),
        ];
    }
}
