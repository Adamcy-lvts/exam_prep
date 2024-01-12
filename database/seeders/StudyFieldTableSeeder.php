<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudyFieldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      

        // Retrieve exam IDs
      

        // Fields of study data for all exams
        $fieldsOfStudyData = [
            // Fields for JAMB
            ['field_name' => 'Natural Science', 'description' => 'Includes Biology, Chemistry, Physics, and Mathematics.'],
            ['field_name' => 'Arts and Humanities', 'description' => 'Includes Literature in English, Fine Art, Music, and Languages.'],
            ['field_name' => 'History and Geography', 'description' => 'Includes History, Geography, and Social Studies.'
            ],
            ['field_name' => 'Commerce & Economics', 'description' => 'Includes Commerce, Economics, Accounting, and Business Studies.'],
            ['field_name' => 'Applied Sciences & Technology', 'description' => 'Includes Computer Science, Agricultural Science, and Technical Drawing.'],
            ['field_name' => 'Social Sciences', 'description' => 'Includes Government, Sociology, Psychology, and Civic Education.'],

            
        ];


        // Insert fields of study into the database
        DB::table('field_of_studies')->insert($fieldsOfStudyData);
    }
}
