<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ProgrammeTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ShieldSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(NounFacultySeeder::class);
        $this->call(CoursesSeeder::class);
        $this->call(ExamTableSeeder::class);
        $this->call(StudyFieldTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(TopicsSeeder::class);
        $this->call(PlansSeeder::class);
        $this->call(PhysicsQuestionSeeder::class);
        $this->call(PhysicsSubjectSeeder::class);
        $this->call(ChemistryQuestionSeeder::class);
        $this->call(BiologyQuestionSeeder::class);
        $this->call(EnglishQuestionSeeder::class);
        $this->call(MathematicsQuestionSeeder::class);
        $this->call(ProgrammeSeeder::class);
        // $this->call(UserRegistrationSeeder::class);
        // $this->call(QuizDataSeeder::class);
    }
}
