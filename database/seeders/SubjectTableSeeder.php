<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve JAMB exam ID
        $jambExamId = DB::table('exams')->where('exam_name', 'JAMB')->value('id');

        // List of all subjects
        $subjects = [
            'Biology', 
            'Chemistry', 
            'Physics', 
            'Mathematics', 
            'Use of English', 
            'Fine Art', 'Music', 
            'History', 'Geography', 
            'Commerce', 'Economics', 
            'Accounting', 'Business Studies', 
            'Computer Science', 'Agricultural Science', 
            'Technical Drawing', 'Government', 'Sociology', 
            'Psychology', 'Civic Education'
        ];

        // Prepare the subjects for insertion
        $subjectsForInsertion = [];
        foreach ($subjects as $subjectName) {
            $subjectsForInsertion[] = [
                'name' => $subjectName,
                'exam_id' => $jambExamId,
            ];
        }

        // Insert the subjects into the database
        DB::table('subjects')->insert($subjectsForInsertion);
    }
}