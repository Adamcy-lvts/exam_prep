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
        // Retrieve field IDs
        $fields = DB::table('field_of_studies')->pluck('id', 'field_name');

        // Retrieve exam IDs
        $exams = DB::table('exams')->pluck('id', 'exam_name');

        // Define the subjects for each exam
        $subjectsForAllExams = [];

        // List of all subjects by field
        $subjectsByField = [
            'Natural Science' => ['Biology', 'Chemistry', 'Physics', 'Mathematics', 'Use of English'],
            'Arts and Humanities' => ['Use of English', 'Fine Art', 'Music','Mathematics'],
            'History and Geography' => ['History', 'Geography','Mathematics', 'Use of English'],
            'Commerce & Economics' => ['Commerce', 'Economics', 'Accounting', 'Business Studies','Mathematics', 'Use of English'],
            'Applied Sciences & Technology' => ['Computer Science', 'Agricultural Science', 'Technical Drawing','Mathematics', 'Use of English'],
            'Social Sciences' => ['Government', 'Sociology', 'Psychology', 'Civic Education','Mathematics', 'Use of English'],
        ];

        foreach ($exams as $examName => $examId) {
            foreach ($subjectsByField as $fieldName => $subjects) {
                foreach ($subjects as $subjectName) {
                    $subjectsForAllExams[] = [
                        'name' => $subjectName,
                        'field_id' => $fields[$fieldName],
                        'exam_id' => $examId,
                    ];
                }
            }
        }

        // Insert subjects into the database
        DB::table('subjects')->insert($subjectsForAllExams);
    }
}
