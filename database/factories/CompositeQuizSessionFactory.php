<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\CompositeQuizSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompositeQuizSession>
 */
class CompositeQuizSessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CompositeQuizSession::class;

    public function definition()
    {
        $startTime = Carbon::now()->subHours(rand(1, 5));
        $endTime = (clone $startTime)->addMinutes(rand(60, 180));
        $duration = $endTime->diffInMinutes($startTime);
        $allowedAttempts = rand(1, 3);
        $completed = $this->faker->boolean(80); // 80% chance that the session is completed

        return [
            'user_id' => \App\Models\User::factory(), // Generate a user for each session or use existing
            'start_time' => $startTime,
            'end_time' => $completed ? $endTime : null, // If not completed, end time is null
            'duration' => $duration,
            'allowed_attempts' => $allowedAttempts,
            'completed' => $completed,
            'total_score' => $completed ? rand(100, 400) : 0, // If not completed, score is 0
        ];
    }
}
