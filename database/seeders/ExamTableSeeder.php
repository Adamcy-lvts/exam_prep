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
            ['exam_name' => 'JAMB', 'exam_logo' => 'images/jamb_logo.png', 'description' => 'Joint Admissions and Matriculation Board'],
            ['exam_name' => 'NOUN','exam_logo' => null, 'description' => 'National Open University of Nigeria']
        ]);
    }
}
