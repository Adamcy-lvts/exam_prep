<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('plans')->insert([
            [
                'type' => 'subject',
                'title' => 'Explorer Access Plan',
                'description' => 'Get a sneak peek into our resource-rich platform with limited quizzes and essential performance insights. Perfect for new users exploring their prep options.',
                'price' => 0.00,
                'currency' => 'NGN',
                'number_of_attempts' => 3,
                'features' => json_encode([
                    '3 quiz Attempt per subject',
                    '3 JAMB exam Session',
                    '20 questions per quiz',
                    'Performance metrics',
                    'Correct answers overview',
                ]),
                'cto' => 'Free Plan',
                'validity_days' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'subject',
                'title' => 'Precision Prep Plan',
                'description' => 'Ideal for candidates preparing for the JAMB exam. Experience a comprehensive simulation of the actual exam environment with our Jamb Test Experience Plan. ',
                'price' => 2200.00,
                'currency' => 'NGN',
                'number_of_attempts' => 10,
                'features' => json_encode([
                    'Quiz Attempts: 10 Attempts',
                    'Flexible quizzes (20-70 questions)',
                    'Extensive question bank',
                    'Interactive study modules',
                    'Performance insights',
                    'Answer Review',
                    'Progress tracking',
                    'Dark Mode Support'
                ]),
                'cto' => 'Purchase Plan',
                'validity_days' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'subject',
                'title' => 'Strategic Study Spectrum',
                'description' => 'Embrace a limitless preparation journey with advanced analytics and complete access to our study modules and AI predictions. Best for students committed to achieving peak performance.',
                'price' => 4200.00,
                'currency' => 'NGN',
                'number_of_attempts' => null, // Representing unlimited attempts
                'features' => json_encode([
                    'Unlimited Quiz Attempts for 30 days',
                    'Flexible quizzes (20-150 questions)',
                    'Advanced AI forecasting',
                    'Interactive study modules',
                    'In-depth analytics',
                    'Smart review focus',
                    'Dark Mode Support',
                    'Answer Review and Explanations',
                    'Generate Reading Timetable'
                ]),
                'cto' => 'Purchase Plan',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'type' => 'course',
                'title' => 'Free Access Plan',
                'description' => 'Get a sneak peek into our resource-rich platform with limited quizzes and essential performance insights. Perfect for new users exploring their prep options.',
                'price' => 0.00,
                'currency' => 'NGN',
                'number_of_attempts' => 3,
                'features' => json_encode([
                    '2 quiz Attempt per course',
                    '20 questions per quiz',
                    'Performance metrics',
                    'Correct answers overview',
                ]),
                'cto' => 'Free Plan',
                'validity_days' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'course',
                'title' => 'Precision Prep Plan',
                'description' => 'Ideal for candidates preparing for the JAMB exam. Experience a comprehensive simulation of the actual exam environment with our Jamb Test Experience Plan. ',
                'price' => 2000.00,
                'currency' => 'NGN',
                'number_of_attempts' => 10,
                'features' => json_encode([
                    'Quiz Attempts: 10 Attempts on all courses',
                    'Flexible quizzes (20-70 questions)',
                    'Extensive question bank',
                    'Performance insights',
                    'Answer Review',
                    'Progress tracking',
                ]),
                'cto' => 'Purchase Plan',
                'validity_days' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'course',
                'title' => 'Strategic Study Spectrum',
                'description' => 'Embrace a limitless preparation journey with advanced analytics and complete access to our study modules and AI predictions. Best for students committed to achieving peak performance.',
                'price' => 5000.00,
                'currency' => 'NGN',
                'number_of_attempts' => null, // Representing unlimited attempts
                'features' => json_encode([
                    'Unlimited Quiz Attempts for 30 days',
                    'Flexible quizzes (20-150 questions)',
                    'Extensive question bank',
                    'In-depth analytics',
                    'Smart review focus',
                    'Answer Review and Explanations',
           
                ]),
                'cto' => 'Purchase Plan',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
