<?php

namespace Database\Factories;

use App\Models\Option;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Option::class;

    public function definition()
    {
        return [
            'question_id' => \App\Models\Question::factory(),
            'option' => $this->faker->sentence(6),
            'is_correct' => $this->faker->boolean(25), // 25% chance of being correct
        ];
    }
}
