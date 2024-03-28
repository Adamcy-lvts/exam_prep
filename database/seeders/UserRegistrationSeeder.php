<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subMonths(12);

        for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
            // Generate a random number of users for each month
            $numUsers = rand(1, 100);

            for ($i = 0; $i < $numUsers; $i++) {
                DB::table('users')->insert([
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'email' => Str::random(10) . '@gmail.com',
                    'password' => Hash::make('password'),
                    'remember_token' => Str::random(60),
                    'created_at' => $date->format('Y-m-d H:i:s'),
                    'updated_at' => $date->format('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
