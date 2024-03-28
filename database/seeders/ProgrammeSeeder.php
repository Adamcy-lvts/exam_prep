<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve subject IDs
        $subjects = DB::table('subjects')->pluck('id', 'name');

        // Define the programmes
        $programmes = [
            'Medicine and Surgery' => ['max_subjects' => 4, 'subjects' => ['Use of English', 'Physics', 'Chemistry', 'Biology'], 'default_subjects' => ['Use of English', 'Physics', 'Chemistry', 'Biology']],
            'Engineering' => ['max_subjects' => 4, 'subjects' => ['Use of English', 'Mathematics', 'Physics', 'Chemistry'], 'default_subjects' => ['Use of English', 'Mathematics', 'Physics', 'Chemistry']],
            'Computer Science' => ['max_subjects' => 4, 'subjects' => ['Use of English', 'Mathematics', 'Physics', 'Biology', 'Chemistry', 'Economics', 'Geography'], 'default_subjects' => ['Use of English', 'Mathematics', 'Physics', 'Biology']],
            'Pharmacy' => ['max_subjects' => 4, 'subjects' => ['Use of English', 'Physics', 'Chemistry', 'Biology'], 'default_subjects' => ['Use of English', 'Physics', 'Chemistry', 'Biology']],
        ];

        // Insert the programmes into the database
        foreach ($programmes as $programmeName => $programme) {
            $programmeId = DB::table('programmes')->insertGetId([
                'name' => $programmeName,
                'slug' => Str::slug($programmeName),
                'max_subjects' => $programme['max_subjects'],
            ]);

            // Prepare the programme's subjects for insertion
            $programmeSubjectsForInsertion = array_map(function ($subjectName) use ($programmeId, $subjects, $programme) {
                return [
                    'programme_id' => $programmeId,
                    'subject_id' => $subjects[$subjectName],
                    'is_default' => in_array($subjectName, $programme['default_subjects']),
                ];
            }, $programme['subjects']);

            // Insert the programme's subjects into the pivot table
            DB::table('programme_subject')->insert($programmeSubjectsForInsertion);
        }
    }
}
