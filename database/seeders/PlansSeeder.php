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
                'title' => 'Free Plan',
                'description' => 'Perfect for new users exploring their prep options.',
                'price' => 0.00,
                'currency' => 'NGN',
                'number_of_attempts' => 5,
                'features' => json_encode([
                    '5 free attempts per month',
                    '20 questions per quiz',
                    'Basic performance tracking',
                    'Access to limited question bank'
                ]),
                'cto' => 'Get Started',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'subject',
                'title' => 'Pro Plan',
                'description' => 'Ideal for serious candidates preparing for the JAMB exam.',
                'price' => 2500.00,
                'currency' => 'NGN',
                'number_of_attempts' => 10,
                'features' => json_encode([
                    '10 attempts per subject',
                    '70 questions per quiz',
                    'Full access to question bank',
                    'Detailed performance analytics'
                ]),
                'cto' => 'Choose Pro',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'subject',
                'title' => 'Unlimited Plan',
                'description' => 'Best for students committed to achieving peak performance.',
                'price' => 5000.00,
                'currency' => 'NGN',
                'number_of_attempts' => null, // Representing unlimited attempts
                'features' => json_encode([
                    'Unlimited attempts',
                    'Up to 150 questions per quiz',
                    'Full access to all features',
                    'Priority support'
                ]),
                'cto' => 'Choose Unlimited',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'type' => 'course',
                'title' => 'Free Plan',
                'description' => 'Perfect for new users exploring their course prep options.',
                'price' => 0.00,
                'currency' => 'NGN',
                'number_of_attempts' => 5,
                'features' => json_encode([
                    '5 free attempts per month',
                    '20 questions per quiz',
                    'Basic performance tracking',
                    'Access to limited question bank'
                ]),
                'cto' => 'Get Started',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'course',
                'title' => 'Pro Plan',
                'description' => 'Ideal for serious candidates preparing for the JAMB exam with course-specific focus.',
                'price' => 2500.00,
                'currency' => 'NGN',
                'number_of_attempts' => 10,
                'features' => json_encode([
                    '10 attempts per course',
                    '70 questions per quiz',
                    'Full access to course question bank',
                    'Detailed performance analytics'
                ]),
                'cto' => 'Choose Pro',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'course',
                'title' => 'Unlimited Plan',
                'description' => 'Best for students committed to achieving peak performance in their course preparation.',
                'price' => 5000.00,
                'currency' => 'NGN',
                'number_of_attempts' => null, // Representing unlimited attempts
                'features' => json_encode([
                    'Unlimited attempts for all courses',
                    'Up to 150 questions per quiz',
                    'Full access to all course features',
                    'Priority support'
                ]),
                'cto' => 'Choose Unlimited',
                'validity_days' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]


        ]);
    }
}
