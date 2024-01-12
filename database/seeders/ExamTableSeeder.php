<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('exams')->insert([
            ['exam_name' => 'JAMB', 'description' => 'Joint Admissions and Matriculation Board'],
            ['exam_name' => 'WAEC', 'description' => 'West African Examinations Council'],
            ['exam_name' => 'NECO', 'description' => 'National Examinations Council'],
            ['exam_name' => 'NOUN', 'description' => 'National Open University of Nigeria']
        ]);
    }
}
