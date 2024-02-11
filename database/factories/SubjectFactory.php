<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Subject::class;

    public function definition()
    {
        // Assuming 'field_of_studies' and 'exams' tables have been seeded and their IDs are available.
        // This will retrieve random IDs from these tables for the foreign keys.
        $fieldId = \App\Models\FieldOfStudy::inRandomOrder()->first()->id ?? null;
        $examId = \App\Models\Exam::inRandomOrder()->first()->id ?? null;

        return [
            'name' => $this->faker->unique()->word,
            'field_id' => $fieldId,
            'exam_id' => $examId,
            // If syllabus is a JSON field, you can encode an array or object. Adjust as needed.
            'syllabus' => json_encode($this->faker->paragraphs(rand(2, 5))),
        ];
    }
}
