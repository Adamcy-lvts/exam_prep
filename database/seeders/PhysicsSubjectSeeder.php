<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhysicsSubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Assume we already have the 'Physics' subject and its corresponding 'field_id' and 'exam_id'
        $physicsId = DB::table('subjects')->where('name', 'Physics')->value('id');

        // Insert the subject topic 'Motion' and get the inserted ID
        $motionTopicId = DB::table('subject_topics')->insertGetId([
            'subject_id' => $physicsId,
            'name' => 'Motion',
            'description' => 'The study of movement and the forces that result in or change motion.',
            'order' => 1,
            'learning_objectives' => json_encode([
                'Understand the different types of motion',
                'Explore the causes and equations of motion',
            ]),
            'key_concepts' => json_encode([
                'Newton\'s Laws of Motion',
                'Kinematics and Dynamics',
            ]),
            'real_world_application' => json_encode([
                'The principles of motion are applied in designing vehicles, predicting planetary movements, and analyzing mechanical systems.',
            ]),
        ]);

        // Insert the subject topic 'Scalars and Vectors' and get the inserted ID
        $scalarsVectorsTopicId = DB::table('subject_topics')->insertGetId([
            'subject_id' => $physicsId,
            'name' => 'Scalars and Vectors',
            'description' => 'Understanding the mathematical and physical concepts of scalar and vector quantities.',
            'order' => 2,
            'learning_objectives' => json_encode([
                'Distinguish between scalar and vector quantities',
                'Understand vector operations and their applications',
            ]),
            'key_concepts' => json_encode([
                'Scalar Quantities',
                'Vector Quantities',
                'Vector Addition and Subtraction',
            ]),
            'real_world_application' => json_encode([
                'Vector analysis in physics is crucial for understanding forces, velocities, and other vector quantities in science and engineering.',
            ]),
        ]);

        // Define the subtopic content for 'Motion'
        $subTopicContentMotion = <<<HTML
<h2>Types of Motion</h2>
<p>Motion is a fundamental concept in physics that refers to the change in position of an object over time. It is an essential part of our daily experience, from the vehicles that transport us to the celestial bodies we observe in the sky. In physics, motion is categorized into several types, each with distinct characteristics.</p>
<!-- Additional HTML content here -->
HTML;

        // Define the subtopic content for 'Scalars and Vectors'
        $subTopicContentScalarsVectors = <<<HTML
<h2>Scalars and Vectors</h2>
<p>In physics, it's essential to differentiate between scalar and vector quantities. Scalars are described by a magnitude only, such as temperature or mass. In contrast, vectors have both magnitude and direction, like velocity or force.</p>
<!-- Additional HTML content here -->
HTML;

        // Insert the subtopic for 'Motion'
        DB::table('sub_topics')->insert([
            'subject_topic_id' => $motionTopicId,
            'title' => 'Types of Motion',
            'content' => $subTopicContentMotion,
        ]);

        // Insert the subtopic for 'Scalars and Vectors'
        DB::table('sub_topics')->insert([
            'subject_topic_id' => $scalarsVectorsTopicId,
            'title' => 'Scalars and Vectors',
            'content' => $subTopicContentScalarsVectors,
        ]);
    }
}
