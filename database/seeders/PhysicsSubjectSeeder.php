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
        // First, ensure the 'Physics' subject is present and fetch its ID
        $physicsId = DB::table('subjects')->where('name', 'Physics')->value('id');

        // Insert the topic 'Motion' into the 'topics' table

        $motionTopicId = DB::table('topics')->where('name', 'Motion')->value('id');

        $subTopicContentMotion = <<<HTML
<h2>Understanding Motion</h2>
<p>Motion is a key concept in physics that describes the change in position of an object over time. It's observed universally, from the smallest particles to the largest celestial bodies. Understanding motion is fundamental to the study of physics and applies to various real-world scenarios.</p>

<h3>Types of Motion</h3>
<ul>
    <li><strong>Linear Motion:</strong> Movement in a straight line, such as a car driving on a straight road.</li>
    <li><strong>Rotational Motion:</strong> Circular movement around an axis, like the Earth rotating around its axis.</li>
    <li><strong>Oscillatory Motion:</strong> Back and forth movement in a regular interval, such as a pendulum.</li>
</ul>

<h3>Equations of Motion</h3>
<p>The equations of motion describe the relationship between an object's displacement, velocity, acceleration, and time. They are crucial for predicting future motion based on current measurements.</p>

<h3>Newton's Laws of Motion</h3>
<ol>
    <li>Every object in a state of uniform motion tends to remain in that state of motion unless an external force is applied to it.</li>
    <li>The relationship between an object's mass m, its acceleration a, and the applied force F is F = ma.</li>
    <li>For every action, there is an equal and opposite reaction.</li>
</ol>

<h3>Real-World Applications</h3>
<p>Understanding motion is crucial for the development of various technologies, including transportation systems, athletic equipment, and space exploration.</p>
HTML;


        // Insert the topic content for 'Motion' into 'topic_contents'
        DB::table('topic_contents')->insert([
            'subject_id' => $physicsId,
            'topic_id' => $motionTopicId,
            'description' => 'The study of movement and the forces that result in or change motion.',
            // Assuming 'order' should be in 'topics' or handled differently as 'topic_contents' doesn't have 'order' field
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
            'content' => $subTopicContentMotion, // Your HTML content
        ]);

        $subTopicContentGravitationalField = <<<HTML
<h2>Gravitational Field</h2>
<p>The gravitational field is a model used to explain the influence that a massive object exerts on space around it, resulting in a force that pulls other objects towards its center. Every object with mass generates a gravitational field that extends throughout space.</p>

<h3>Characteristics of Gravitational Fields</h3>
<p>Gravitational fields are vector fields that point towards the center of the mass creating the field. The strength of the field decreases with distance from the mass according to the inverse-square law.</p>

<h3>Gravitational Field Strength</h3>
<p>The gravitational field strength at a point in space is defined as the force per unit mass experienced by a small test mass placed at that point. It is measured in Newtons per kilogram (N/kg).</p>

<h3>Equations of Gravitational Fields</h3>
<p>The gravitational field strength (g) near the surface of an object with mass (M) can be calculated using the formula:</p>
<p>\[g = \frac{G \times M}{r^2}\]</p>
<p>where \(G\) is the universal gravitational constant, and \(r\) is the distance from the center of the mass to the point in the field.</p>

<h3>Gravitational Potential Energy</h3>
<p>Gravitational potential energy is the energy stored in an object as a result of its position within a gravitational field. The higher the object is within the field, the greater its potential energy.</p>

<h3>Applications of Gravitational Fields</h3>
<p>Understanding gravitational fields is crucial for satellite deployment, predicting planetary orbits, and studying the distribution of galaxies in the universe. It also plays a key role in theories that describe the universe's structure and dynamics, such as general relativity.</p>
HTML;

        $gravitationalFieldTopicId = DB::table('topics')->where(
            'name',
            'Gravitational Field'
        )->value('id');

        // Insert the topic content for 'Gravitational Field'
        DB::table('topic_contents')->insert([
            'subject_id' => $physicsId,
            'topic_id' => $gravitationalFieldTopicId,
            'description' => 'Exploration of gravitational fields and their effects.',
            'learning_objectives' => json_encode([
                'Explain the concept of a gravitational field and its characteristics',
                'Calculate gravitational field strength using the universal law of gravitation',
                'Describe gravitational potential energy and its significance',
            ]),
            'key_concepts' => json_encode([
                'Gravitational Field Strength',
                'Inverse-Square Law',
                'Gravitational Potential Energy',
            ]),
            'real_world_application' => json_encode([
                'Satellite technology',
                'Astronomical observations',
                'Theoretical physics',
            ]),
            'content' => $subTopicContentGravitationalField, // Your HTML content
        ]);
    }
}
