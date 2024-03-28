<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NounFacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Prepare faculties data (adapted from NOUN website)
        $faculties = [
            [
                'faculty_name' => 'Faculty of Arts',
                'code' => 'FA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Education',
                'code' => 'FOE',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Law',
                'code' => 'LAW',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Management Sciences',
                'code' => 'FMS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Science',
                'code' => 'FOS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Social Sciences',
                'code' => 'FSS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Agricultural Sciences',
                'code' => 'FAS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'faculty_name' => 'Faculty of Health Sciences',
                'code' => 'FHS',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'faculty_name' => 'DE and General Studies',
                'code' => 'DEGS',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert faculties into database
        DB::table('faculties')->insert($faculties);
    }
}


