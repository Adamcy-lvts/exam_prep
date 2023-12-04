<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoursesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate existing records to start from scratch.
        Course::truncate();

        $courses = [
            ['code' => 'GST807', 'title' => 'A Study Guide For The Distance Learner', 'duration' => 45, 'total_marks' => 70],
            ['code' => 'GST103', 'title' => 'Computer Fundamentals', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST105', 'title' => 'History And Philosophy Of Science', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST201', 'title' => 'Nigerian Peoples And Culture', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST202', 'title' => 'Fundamentals Of Peace Studies And Conflict Resolution', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST107', 'title' => 'A Study Guide For The Distance Learner', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST101', 'title' => 'Use Of English & Communication Skills I', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST104', 'title' => 'Use Of Library', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST102', 'title' => 'Use Of English & Communication Skills II', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST204', 'title' => 'Entrepreneurship And Innovation', 'duration' => 45, 'total_marks' => 70 ],
            ['code' => 'GST203', 'title' => 'Introduction To Philosophy And Logic', 'duration' => 45, 'total_marks' => 70 ],
        ];

        foreach ($courses as $course) {
            Course::create([
                'course_code' => $course['code'],
                'title' => $course['title'],
                'duration' => $course['duration'],
                'total_marks' => $course['total_marks']
                // Add additional fields here, if your table structure has more columns.
            ]);
        }
    }
}
