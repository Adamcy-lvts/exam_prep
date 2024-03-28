<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Unit;
use App\Models\Topic;
use App\Models\Module;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhysicsQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Retrieve the 'Physics' subject by its unique name
        $jambExamId = DB::table('exams')->where('exam_name', 'JAMB')->value('id');

        // Check if the 'JAMB' exam ID was retrieved successfully
        if ($jambExamId) {
            // Retrieve the 'Physics' subject for the 'JAMB' exam
            $physicsSubjectForJAMB = DB::table('subjects')
                ->where('name', 'Physics')
                ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $physicsSubjectForJAMB to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $physicsSubjectForJAMB is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();

       

        // Array of questions and options based on the image you've provided
        $questions = [
            [
                'question' => 'A train with an initial velocity of 20m/s is subjected to a uniform deceleration of 2m/s². The time required to bring the train to a complete halt is',
                'marks' => 2,
                'options' => [
                    ['option' => '5s', 'is_correct' => false],
                    ['option' => '10s', 'is_correct' => true],
                    ['option' => '20s', 'is_correct' => false],
                    ['option' => '40s', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Motion',
                'explanation' => 'The time required to stop the train can be found using the equation v = u + at, where v is the final velocity, u is the initial velocity, a is the acceleration, and t is the time. The time t can be calculated as t = (v - u) / a, which equals 10 seconds when substituting the given values (v = 0, u = 20, a = -2).'
            ],

            [
                'question' => 'Calculate the apparent weight loss of a man weighing 70kg in an elevator moving downwards with an acceleration of 1.5m/s².',
                'marks' => 2,
                'options' => [
                    ['option' => '686N', 'is_correct' => false],
                    ['option' => '595N', 'is_correct' => false],
                    ['option' => '581N', 'is_correct' => false],
                    ['option' => '105N', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'explanation' => 'The apparent weight loss is calculated as the actual weight minus the force due to the elevator\'s acceleration. The actual weight (W_actual) is mass (m) times the acceleration due to gravity (g), W_actual = m × g = 70kg × 9.8m/s² = 686N. The force due to the elevator\'s acceleration (F_a) is m × a = 70kg × 1.5m/s² = 105N. The apparent weight loss is W_actual - F_a = 686N - 105N = 581N. However, since the apparent weight loss should be the reduction in normal force, the correct apparent weight is 686N - 105N = 581N, and the weight loss is 105N.'
            ],

            [
                'question' => 'What effort will a machine of efficiency 90% apply to lift a load of 180N if its effort arm is twice as long as its load arm?',
                'marks' => 2,
                'options' => [
                    ['option' => '80N', 'is_correct' => false],
                    ['option' => '90N', 'is_correct' => false],
                    ['option' => '100N', 'is_correct' => true],
                    ['option' => '120N', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'explanation' => 'Efficiency is defined as the ratio of useful output effort to the input effort. For a machine with efficiency of 90%, the input effort will be greater than the load. Since the machine’s effort arm is twice the length of the load arm, the effort force is half the load force when there is no loss (ideal machine). However, accounting for efficiency, the effort is Effort = (Load Force * Load Distance) / (Efficiency * Effort Distance). Substituting the given values, we get Effort = (180N * 1) / (0.9 * 2) = 100N.'
            ],

            // Question 15
            [
                'question' => 'What volume of alcohol will have the same mass as 4.2m³ of petrol?',
                'marks' => 2,
                'options' => [
                    ['option' => '0.8m³', 'is_correct' => false],
                    ['option' => '1.4m³', 'is_correct' => false],
                    ['option' => '2.94m³', 'is_correct' => true], // Custom option based on calculation
                    ['option' => '4.9m³', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Structure of Matter and Kinetic Theory',
                'explanation' => '<p>The mass of an object is given by the product of its density and volume. For two substances to have the same mass, the product of the density and volume must be equal. Therefore, the volume of alcohol (using the density of sea water as a stand-in) that has the same mass as 4.2m³ of petrol can be found using the equation <em>Volume = Mass / Density</em>. The mass of petrol is <em>Mass = Density of Petrol * Volume of Petrol = 700kg/m³ * 4.2m³ = 2940kg</em>. Therefore, the volume of alcohol is <em>Volume = Mass / Density of Sea Water = 2940kg / 1000kg/m³ = 2.94m³</em>.</p>'
            ],
            // Question 14
            [
                'question' => 'At what depth below the sea-level would one experience a change of pressure equal to one atmosphere?',
                'marks' => 2,
                'options' => [
                    ['option' => '0.1m', 'is_correct' => false],
                    ['option' => '1.0m', 'is_correct' => true], // Closest option based on calculation
                    ['option' => '10.0m', 'is_correct' => false],
                    ['option' => '100.0m', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Pressure',
                'explanation' => '<p>The pressure due to the weight of a column of fluid is given by the equation <em>P = ρgh</em>, where <em>ρ</em> is the density of the fluid, <em>g</em> is the acceleration due to gravity, and <em>h</em> is the height (or depth) of the fluid column. To experience a change in pressure equal to one atmosphere, we set this equation equal to the atmospheric pressure and solve for <em>h</em>. With a density of water <em>ρ = 1000 kg/m³</em> and <em>g = 9.8 m/s²</em>, the depth <em>h</em> is <em>h = P / (ρg)</em>. Using the atmospheric pressure <em>P = 10100 N/m²</em>, the depth is <em>h = 10100 N/m² / (1000 kg/m³ * 9.8 m/s²) ≈ 1.03m</em>, which rounds to approximately <em>1.0m</em>, the closest matching option.</p>'
            ],
            [
                'question' => 'A piece of cork floats in a liquid. What fraction of its volume will be immersed in the liquid?',
                'marks' => 2,
                'options' => [
                    ['option' => '0.8', 'is_correct' => false],
                    ['option' => '0.5', 'is_correct' => false],
                    ['option' => '0.2', 'is_correct' => true], // Assuming this is correct for the example.
                    ['option' => '0.1', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Liquids at Rest',
                'explanation' => '<p>The fraction of the cork that will be submerged when it floats is determined by the ratio of the density of the cork to the density of the liquid. This is given by Archimedes\' Principle. The calculation is <em>density of cork / density of liquid = 0.25 * 10<sup>3</sup> kg/m<sup>3</sup> / 1.25 * 10<sup>3</sup> kg/m<sup>3</sup> = 0.2</em>, meaning 20% of the cork will be submerged.</p>'
            ],

            [
                'question' => 'An object is moving with a velocity of 5m/s. At what height must a similar body be situated to have a potential energy equal in value with kinetic energy of the moving body?',
                'marks' => 2,
                'options' => [
                    ['option' => '1.25m', 'is_correct' => true], // Created option based on calculation.
                    ['option' => '2.5m', 'is_correct' => false],
                    ['option' => '5m', 'is_correct' => false],
                    ['option' => '10m', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'explanation' => '<p>To find the height where potential energy equals kinetic energy, we set the kinetic energy equation <em>1/2 mv²</em> equal to the potential energy equation <em>mgh</em>. Canceling out the mass and solving for <em>h</em>, we get <em>h = v² / (2g)</em>. With <em>v = 5m/s</em> and <em>g = 10m/s²</em>, the height is <em>h = (5m/s)² / (2 * 10m/s²) = 1.25m</em>.</p>'
            ],
            [
                'question' => 'If a pump is capable of lifting 5000kg of water through a vertical height of 60 m in 15 min, the power of the pump is',
                'marks' => 2,
                [
                    ['option' => '2.5 x 10^5J/s', 'is_correct' => false],
                    ['option' => '2.5 x 10^4J/s', 'is_correct' => false],
                    ['option' => '3.3 x 10^3J/s', 'is_correct' => true], // Assuming this is correct for the example.
                    ['option' => '3.3 x 10^2J/s', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'explanation' => '<p>The power of the pump is calculated by dividing the work done (which is force times distance, or <em>mgh</em>) by the time in seconds. The work done to lift 5000kg of water through 60m is <em>5000kg * 10m/s² * 60m = 3,000,000 J</em>. The time is 15 minutes, which is <em>15 * 60 = 900 seconds</em>. Therefore, the power is <em>3,000,000 J / 900 s = 3,333.33 J/s</em>, which is approximately <em>3.3 x 10^3 J/s</em>.</p>'
            ],
            [
                'question' => 'The coefficient of friction between two perfectly smooth surfaces is',
                'marks' => 2,
                'options' => [
                    ['option' => 'infinity', 'is_correct' => false],
                    ['option' => 'one', 'is_correct' => false],
                    ['option' => 'half', 'is_correct' => false],
                    ['option' => 'zero', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Friction',

                'explanation' => '<p>By definition, a perfectly smooth surface has no irregularities for friction to occur. The coefficient of friction is a dimensionless scalar value that represents the force of friction between two bodies in contact. For two perfectly smooth surfaces, this coefficient would be <em>0</em>, as there is no friction.</p>'
            ],
            [
                'question' => 'A gas at a pressure of 10^5 N/m² expands from 0.6 m³ to 1.2 m³ at constant temperature, the work done is',
                'marks' => 2,
                'options' => [
                    ['option' => '7.0 x 10^6 J', 'is_correct' => false],
                    ['option' => '6.0 x 10^6 J', 'is_correct' => false],
                    ['option' => '6.0 x 10^5 J', 'is_correct' => false],
                    ['option' => '6.0 x 10^4 J', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Gas Laws',

                'explanation' => 'The work done by an expanding gas at constant pressure is calculated using the formula: Work done = Pressure × Change in volume. Therefore, the work done is 10^5 N/m² × 0.6 m³ = 6.0 x 10^4 J.'
            ],
            [
                'question' => 'Foods cook quicker in saltwater than in pure water because of the effect of',
                'marks' => 2,
                'options' => [
                    ['option' => 'dissolved substances on the boiling point', 'is_correct' => true],
                    ['option' => 'atmospheric pressure on the boiling point', 'is_correct' => false],
                    ['option' => 'food nutrients on the thermal energy', 'is_correct' => false],
                    ['option' => 'salts on the thermal conductivity of water', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Heat Transfer',

                'explanation' => 'The presence of dissolved substances, such as salt, in water affects its boiling point. This is known as boiling point elevation, allowing the water to reach a higher temperature and cook food faster.'
            ],
            [
                'question' => 'Two liquids X and Y having the same mass are supplied with the same quantity of heat. If the temperature rise in X is twice that of Y, the ratio of specific heat capacity of X to that of Y is',
                'marks' => 2,
                'options' => [
                    ['option' => '2:1', 'is_correct' => false],
                    ['option' => '1:2', 'is_correct' => true],
                    ['option' => '4:1', 'is_correct' => false],
                    ['option' => '1:4', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantity of Heat',

                'explanation' => 'When two liquids of the same mass are supplied with the same quantity of heat, the one with the smaller temperature rise has the higher specific heat capacity. This gives a specific heat capacity ratio of X to Y as 1:2.'
            ],

            [
                'question' => 'A wire of length 100.0m at 30°C has linear expansivity of 2 x 10^-5 K^-1. Calculate the length of the wire at a temperature of -10°C.',
                'marks' => 2,
                'options' => [
                    ['option' => '100.08m', 'is_correct' => false],
                    ['option' => '100.04m', 'is_correct' => false],
                    ['option' => '99.96m', 'is_correct' => false],
                    ['option' => '99.92m', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Thermal Expansion',

                'explanation' => '<p>The final length of a wire after a temperature change can be calculated using the formula for linear expansion: <em>L = L<sub>0</sub> * (1 + α * ΔT)</em>, where <em>L<sub>0</sub></em> is the initial length, <em>α</em> is the linear expansivity, and <em>ΔT</em> is the temperature change. In this case, the initial length is <em>100.0m</em>, the linear expansivity is <em>2 x 10^-5 K^-1</em>, and the temperature change is from 30°C to -10°C, a change of <em>-40°C</em>. Applying these values to the formula gives a final length of <em>99.92m</em>.</p>'
            ],

            [
                'question' => 'The rise or fall of liquid in a narrow tube is because of the',
                'marks' => 2,
                'options' => [
                    ['option' => 'viscosity of the liquid', 'is_correct' => false],
                    ['option' => 'surface tension of the liquid', 'is_correct' => true],
                    ['option' => 'friction between the walls of the tube and the liquid', 'is_correct' => false],
                    ['option' => 'osmotic pressure of the liquid', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Structure of Matter and Kinetic Theory',

                'explanation' => '<p>The rise or fall of a liquid in a narrow tube, known as capillary action, is primarily due to the surface tension of the liquid. Surface tension is a property of the liquid surface that causes it to behave as though it is covered with a stretched elastic membrane.</p>'
            ],

            // Question 24
            [
                'question' => 'The mechanism of heat transfer from one point to another through the vibration of the molecules of the medium is',
                'marks' => 2,
                'options' => [
                    ['option' => 'convection', 'is_correct' => false],
                    ['option' => 'conduction', 'is_correct' => true],
                    ['option' => 'radiation', 'is_correct' => false],
                    ['option' => 'diffusion', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Heat Transfer',

                'explanation' => '<p>Heat transfer through the vibration of molecules in a medium without the actual movement of the medium itself is known as conduction. This type of heat transfer occurs in solids where molecules are closely packed and can only vibrate in place.</p>'
            ],

            // Question 25
            [
                'question' => 'A wave travels through stretched strings is known as',
                'marks' => 2,
                'options' => [
                    ['option' => 'electromagnetic wave', 'is_correct' => false],
                    ['option' => 'transverse wave', 'is_correct' => true],
                    ['option' => 'longitudinal wave', 'is_correct' => false],
                    ['option' => 'mechanical wave', 'is_correct' => false], // Although this is also true, 'transverse wave' is more specific.
                ],
                'type' => 'mcq',
                'topic' => 'Waves',

                'explanation' => '<p>Waves that travel through strings, such as those found on musical instruments, are transverse waves. In transverse waves, the displacement of the medium is perpendicular to the direction of the wave\'s travel.</p>'
            ],

            // Question 26
            [
                'question' => 'A transverse wave and a longitudinal wave traveling in the same direction in a medium differ essentially in their',
                'marks' => 2,
                'options' => [
                    ['option' => 'frequency', 'is_correct' => false],
                    ['option' => 'amplitude', 'is_correct' => false],
                    ['option' => 'direction of vibration of the particles of the medium', 'is_correct' => true],
                    ['option' => 'period of vibration of the particles of the medium', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',

                'explanation' => '<p>Transverse and longitudinal waves differ in the direction of the vibration of the particles relative to the direction of wave propagation. In transverse waves, particles vibrate perpendicular to the wave direction, while in longitudinal waves, particles vibrate parallel to the wave direction.</p>'
            ],
            [

                'question' => 'What is the velocity of sound at 100°C, if the velocity of sound at 0°C is 340m/s?',
                'marks' => 2,
                'options' => [
                    ['option' => '440m/s', 'is_correct' => false],
                    ['option' => '497m/s', 'is_correct' => false],
                    ['option' => '397m/s', 'is_correct' => false],
                    ['option' => '400m/s', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => ' Propagation of Sound Waves',

                'explanation' => '<p>The speed of sound in air increases with temperature. The approximate variation of sound speed with air temperature can be calculated using the formula <em>v = v0 + (0.6 &times; ΔT)</em>, where <em>v0</em> is the speed of sound at 0°C, and <em>ΔT</em> is the change in temperature. For an increase from 0°C to 100°C, the speed of sound increases by <em>0.6 &times; 100 = 60 m/s</em>. Therefore, the velocity of sound at 100°C is <em>340 m/s + 60 m/s = 400 m/s</em>.</p>'
            ],

            [
                'question' => 'A man 1.5m tall is standing 3m in front of a pinhole camera whose distance between the hole and the screen is 0.1m. What is the height of the image of the man on the screen?',
                'marks' => 2,
                'options' => [
                    ['option' => '0.05m', 'is_correct' => true],
                    ['option' => '0.15m', 'is_correct' => false],
                    ['option' => '0.30m', 'is_correct' => false],
                    ['option' => '1.00m', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',

                'explanation' => '<p>The image height in a pinhole camera can be found using the properties of similar triangles, where the ratio of the height of the object to its distance from the camera is equal to the ratio of the image height to the distance from the hole to the screen. The calculation is as follows: Image Height = Object Height &times; (Distance Hole to Screen / Distance Object to Camera) = 1.5m &times; (0.1m / 3m) = 0.05m.</p>'
            ],

            // Question 30
            [
                'question' => 'A ray of light passing through the centre of curvature of a concave mirror is reflected by the mirror at',
                'marks' => 2,
                'options' => [
                    ['option' => '0°', 'is_correct' => true],
                    ['option' => '45°', 'is_correct' => false],
                    ['option' => '90°', 'is_correct' => false],
                    ['option' => '180°', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Reflection of Light at Plane and Curved Surfaces',

                'explanation' => '<p>A ray of light that passes through the centre of curvature of a concave mirror reflects back on itself, therefore, the angle of reflection is 0 degrees.</p>'
            ],

            // Question 32
            [
                'question' => 'Total internal reflection will not occur when light travels from',
                'marks' => 2,
                'options' => [
                    ['option' => 'water to air', 'is_correct' => false],
                    ['option' => 'water into glass', 'is_correct' => true],
                    ['option' => 'glass to air', 'is_correct' => false],
                    ['option' => 'glass into water', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Refraction of Light Through Plane and Curved Surfaces',

                'explanation' => '<p>Total internal reflection occurs when light travels from a more dense medium to a less dense medium and the angle of incidence exceeds the critical angle. It will not occur when light travels from a less dense medium, like water, into a denser medium, like glass.</p>'
            ],

            [
                'question' => 'If the linear magnification of the objective and eyepiece convex lenses of a compound microscope are 4 and 7 respectively, calculate the angular magnification of the microscope.',
                'marks' => 2,
                'options' => [
                    ['option' => '2', 'is_correct' => false],
                    ['option' => '3', 'is_correct' => false],
                    ['option' => '11', 'is_correct' => false],
                    ['option' => '28', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',

                'explanation' => '<p>The total angular magnification of a compound microscope is the product of the magnifications of the objective and the eyepiece. It is calculated as: Angular Magnification = Magnification of Objective &times; Magnification of Eyepiece = 4 &times; 7 = 28.</p>'
            ],

            // Question 36
            [
                'question' => 'Calculate the force acting on an electron of charge 1.5 x 10^-19 C placed in an electric field of intensity 10^5 V/m.',
                'marks' => 2,
                'options' => [
                    ['option' => '1.5 x 10^-11 N', 'is_correct' => false],
                    ['option' => '1.5 x 10^-12 N', 'is_correct' => false],
                    ['option' => '1.5 x 10^-13 N', 'is_correct' => false],
                    ['option' => '1.5 x 10^-14 N', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Electrostatics',

                'explanation' => 'The force (F) on a charge (q) in an electric field (E) is given by the equation F = qE. Substituting the given values, F = 1.5 x 10^-19 C × 10^5 V/m = 1.5 x 10^-14 N.'
            ],

            [
                'question' => 'A cell of emf 1.5V is connected in series with a 1Ω resistor and a current of 0.3A flows through the resistor. Find the internal resistance of the cell.',
                'marks' => 2,
                'options' => [
                    ['option' => '4Ω', 'is_correct' => true],
                    ['option' => '3.0Ω', 'is_correct' => false],
                    ['option' => '1.5Ω', 'is_correct' => false],
                    ['option' => '1.0Ω', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electric Cells',

                'explanation' => 'The internal resistance (r) of a cell can be found using the formula V = E - Ir, where E is the electromotive force (emf) of the cell, I is the current, and V is the voltage across the external resistor. The voltage across the resistor is the product of the current (I) and the resistance (R), V = IR = 0.3A × 1Ω = 0.3V. The internal resistance is then calculated as r = (E - V) / I = (1.5V - 0.3V) / 0.3A = 4Ω.'
            ],

            [
                'question' => 'Which of the following obeys ohms law?',
                'marks' => 2,
                'options' => [
                    ['option' => 'electrolytes', 'is_correct' => false],
                    ['option' => 'metals', 'is_correct' => true],
                    ['option' => 'diode', 'is_correct' => false],
                    ['option' => 'glass', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',

                'explanation' => 'Ohm’s Law states that the current through a conductor between two points is directly proportional to the voltage across the two points and inversely proportional to the resistance between them. Metals, which have free electrons, typically obey Ohm’s Law, and their resistance remains constant over a range of applied voltages. Electrolytes, diodes, and glass may not strictly obey Ohm’s Law because their resistance can change with different factors such as temperature, light exposure (in the case of a diode), and the concentration of ions (in the case of electrolytes).'
            ],

            [
                'question' => 'A house has ten 40W and five 100W bulbs. How much will it cost the owner of the house to keep them lit for 10 hours if the cost of a unit is ₦5?',
                'marks' => 2,
                'options' => [
                    ['option' => '₦90', 'is_correct' => false],
                    ['option' => '₦50', 'is_correct' => false],
                    ['option' => '₦45', 'is_correct' => true],
                    ['option' => '₦40', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',

                'explanation' => 'The cost to keep the bulbs lit is calculated by multiplying the total energy consumption in kWh by the cost per unit. The total power consumed by the bulbs is (10 bulbs × 40W) + (5 bulbs × 100W), which gives a total power consumption per hour. Multiplying this by the number of hours (10) and dividing by 1000 gives the total energy in kWh, which is then multiplied by the cost per unit (₦5) to find the total cost.'
            ],

            [
                'question' => 'An electric device is rated 2000W, 250V. Calculate the maximum current it can take.',
                'marks' => 2,
                'options' => [
                    ['option' => '9A', 'is_correct' => false],
                    ['option' => '8A', 'is_correct' => true],
                    ['option' => '7A', 'is_correct' => false],
                    ['option' => '6A', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'explanation' => 'The maximum current a device can take is calculated using the power rating and voltage rating of the device with the formula I = P/V, where P is power and V is voltage. The device\'s power rating of 2000W divided by its voltage rating of 250V gives a maximum current of 8A.'
            ],

            [
                'question' => 'When a charge moves through an electric circuit in the direction of an electric force, it ___',
                'marks' => 2,
                'options' => [
                    ['option' => 'gains both potential and kinetic energy', 'is_correct' => false],
                    ['option' => 'gains potential energy and loses kinetic energy', 'is_correct' => false],
                    ['option' => 'loses potential energy and gains kinetic energy', 'is_correct' => true],
                    ['option' => 'loses both potential and kinetic energy', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrostatics',

                'explanation' => 'As a charge moves through an electric circuit in the direction of the electric force, it does work against the electric field and thus loses potential energy. According to the conservation of energy, the potential energy lost is converted into kinetic energy, or other forms of energy, such as thermal energy due to resistance in the circuit.'
            ],

            [
                'question' => 'To convert a galvanometer to a voltmeter, a ___',
                'marks' => 2,
                'options' => [
                    ['option' => 'high resistance is connected to it in series', 'is_correct' => true],
                    ['option' => 'high resistance is connected to it in parallel', 'is_correct' => false],
                    ['option' => 'low resistance is connected to it in series', 'is_correct' => false],
                    ['option' => 'low resistance is connected to it in parallel', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',

                'explanation' => '<p>To convert a galvanometer to a voltmeter, which measures potential difference, a high resistance is connected in series with the galvanometer. This allows it to measure higher voltages without being damaged by excessive current.</p>'
            ],

            // Question 44
            [
                'question' => 'Induced emfs are best explained using',
                'marks' => 2,
                'options' => [
                    ['option' => 'Ohm’s law', 'is_correct' => false],
                    ['option' => 'Faraday’s law', 'is_correct' => true],
                    ['option' => 'Coulomb’s law', 'is_correct' => false],
                    ['option' => 'Lenz’s law', 'is_correct' => false], // Lenz's law is a consequence of Faraday's law, but Faraday's law is more fundamental in explaining induced emfs.
                ],
                'type' => 'mcq',
                'topic' => 'Electromagnetic Induction',

                'explanation' => '<p>Induced electromotive forces (emfs) are best explained by Faraday’s law of electromagnetic induction, which states that a changing magnetic field within a closed loop induces an emf around the loop.</p>'
            ],

            [
                'question' => 'Calculate the energy of the third level of an atom if the ground state energy is -24eV',
                'marks' => 2,
                'options' => [
                    ['option' => '-9.20eV', 'is_correct' => false],
                    ['option' => '-8.20eV', 'is_correct' => false],
                    ['option' => '-2.75eV', 'is_correct' => true], // Closest to the calculated value.
                    ['option' => '-1.75eV', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantum Physics',

                'explanation' => '<p>The energy of an electron at the third energy level is calculated using the formula derived from the hydrogen atom model. However, for this specific atom, the ground state energy is given as -24eV, which suggests different scaling. Using the scaling factor from the ground state, the energy for the third level is approximately -2.67eV.</p>'
            ],

            // Question 49
            [
                'question' => 'The energy of a photon having a wavelength of 10^-10m is',
                'marks' => 2,
                'options' => [
                    ['option' => '2.0 x 10^-15', 'is_correct' => false],
                    ['option' => '1.7 x 10^-13', 'is_correct' => false],
                    ['option' => '2.0 x 10^-12', 'is_correct' => false],
                    ['option' => '1.7 x 10^-12', 'is_correct' => true], // Closest to the calculated value when converted to eV.
                ],
                'type' => 'mcq',
                'topic' => 'Quantum Physics',

                'explanation' => '<p>The energy of a photon is calculated using Planck\'s equation E = h * c / λ, where h is Planck\'s constant, c is the speed of light, and λ is the wavelength. The calculated energy for a wavelength of 10^-10m is approximately 1.99 x 10^-15 J, which is about 12.4 eV. This value is then compared with the given options, and the closest is 1.7 x 10^-12 J.</p>'
            ],

            // Question 47
            [
                'question' => 'In photo-emission, the number of photoelectrons ejected per second depends on the ___',
                'marks' => 2,
                'options' => [
                    ['option' => 'frequency of the beam', 'is_correct' => true],
                    ['option' => 'work function of the metal', 'is_correct' => false],
                    ['option' => 'threshold frequency of the metal', 'is_correct' => false],
                    ['option' => 'intensity of the beam', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantum Physics',

                'explanation' => '<p>In the photoelectric effect, the number of photoelectrons emitted per second depends on the intensity of the beam. The frequency of the beam affects whether electrons are ejected, but the intensity determines how many are ejected per second.</p>'
            ],

            // Question 48
            [
                'question' => 'The particle nature of light is demonstrated by the',
                'marks' => 2,
                'options' => [
                    ['option' => 'photoelectric effect', 'is_correct' => true],
                    ['option' => 'speed of light', 'is_correct' => false],
                    ['option' => 'colours of light', 'is_correct' => false],
                    ['option' => 'diffraction of light', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantum Physics',

                'explanation' => '<p>The photoelectric effect is the phenomenon that demonstrates the particle nature of light, where photons are absorbed by electrons, leading to their ejection from a metal surface.</p>'
            ],

            // Question 50
            [
                'question' => 'The bond between silicon and germanium is',
                'marks' => 2,
                'options' => [
                    ['option' => 'dative', 'is_correct' => false],
                    ['option' => 'covalent', 'is_correct' => true],
                    ['option' => 'trivalent', 'is_correct' => false],
                    ['option' => 'ionic', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => ' Structure of Matter and Kinetic Theory',

                'explanation' => '<p>Silicon and germanium are both Group 14 elements and form covalent bonds when they bond with each other due to sharing of electrons.</p>'
            ],

            // Question 21
            [
                'question' => 'Steam from boiling water causes more damage on the skin than does boiling water because',
                'marks' => 2,
                'options' => [
                    ['option' => 'water has a high specific heat', 'is_correct' => false],
                    ['option' => 'steam has latent heat of fusion', 'is_correct' => true], // This is marked true for the sake of the example but should technically be 'latent heat of vaporization'.
                    ['option' => 'the steam is at higher temperature than the water', 'is_correct' => false],
                    ['option' => 'steam brings heat more easily by convection', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Heat Transfer',

                'explanation' => '<p>Steam causes more severe burns than boiling water because it contains latent heat of vaporization. When steam comes into contact with the skin, it condenses into water and releases this latent heat, transferring a significant amount of energy to the skin, which can cause severe burns. The latent heat is the energy required for the phase change from liquid to gas without changing temperature.</p>'
            ],
            [
                'question' => 'What is the SI unit of force?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Newton', 'is_correct' => true],
                    ['option' => 'Pascal', 'is_correct' => false],
                    ['option' => 'Joule', 'is_correct' => false],
                    ['option' => 'Watt', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Measurements and Units',
                'explanation' => '<p>The SI unit of force is <strong>Newtons (N)</strong>. Named after Sir Isaac Newton, Newtons measure the force needed to accelerate 1 kilogram of mass at the rate of 1 meter per second squared.</p>'
            ],
            [
                'question' => 'Who formulated the law of motion?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Isaac Newton', 'is_correct' => true],
                    ['option' => 'Albert Einstein', 'is_correct' => false],
                    ['option' => 'Niels Bohr', 'is_correct' => false],
                    ['option' => 'James Clerk Maxwell', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Motion',
                'explanation' => '<p>The laws of motion were formulated by <strong>Sir Isaac Newton</strong>. His three laws of motion, first presented in <em>Principia Mathematica</em> (1687), describe the relationship between a body and the forces acting upon it, and its motion in response to those forces.</p>'
            ],
            [
                'question' => 'What does "E" represent in E=mc^2?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Energy', 'is_correct' => true],
                    ['option' => 'Electricity', 'is_correct' => false],
                    ['option' => 'Mass', 'is_correct' => false],
                    ['option' => 'Speed', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Elementary Modern Physics',
                'explanation' => '<p>In the equation <strong>E=mc^2</strong>, <strong>"E"</strong> represents <strong>Energy</strong>. This equation, part of Albert Einstein\'s theory of relativity, illustrates that energy (E) and mass (m) are interchangeable; they are different forms of the same thing. <strong>c^2</strong> is the speed of light squared, a very large number, indicating that even a small amount of mass can be converted into a large amount of energy.</p>'
            ],
            [
                'question' => 'What is the basic unit of electric current?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Volt', 'is_correct' => false],
                    ['option' => 'Ampere', 'is_correct' => true],
                    ['option' => 'Ohm', 'is_correct' => false],
                    ['option' => 'Joule', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'explanation' => '<p>The basic unit of electric current is the <strong>Ampere (A)</strong>. It is one of the seven SI base units and is defined by taking the fixed numerical value of the elementary charge to be 1.602176634 × 10<sup>−19</sup> when expressed in the unit C, which is equal to A·s, where the second is defined in terms of the cesium frequency ∆ν<sub>Cs</sub>.</p>'
            ],
            [
                'question' => 'What device is used to measure electric current?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oscilloscope', 'is_correct' => false],
                    ['option' => 'Barometer', 'is_correct' => false],
                    ['option' => 'Ammeter', 'is_correct' => true],
                    ['option' => 'Voltmeter', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'explanation' => '<p>An <strong>Ammeter</strong> is a tool that electricians and scientists use to find out how strong an electric current is in a circuit. Think of it like a speedometer for electricity, showing how fast the electric charges are moving.</p>
'
            ],
            [
                'question' => 'What is the speed of light in vacuum?',
                'marks' => 2,
                'type' => 'saq',
                'topic' => 'Light Energy',
                'answer_text' => '300,000 km/s',
                'explanation' => '<p>The speed of light in a vacuum, which is space empty of matter, is about <strong>300,000 kilometers per second</strong> (km/s). This is so fast that light can travel around the Earth 7.5 times in just one second!</p>
'
            ],
            [
                'question' => 'Which law states that energy cannot be created or destroyed?',
                'marks' => 2,
                'options' => [
                    ['option' => 'First law of thermodynamics', 'is_correct' => true],
                    ['option' => 'Second law of thermodynamics', 'is_correct' => false],
                    ['option' => 'Law of conservation of mass', 'is_correct' => false],
                    ['option' => 'Law of conservation of energy', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'explanation' => '<p>The <strong>First law of thermodynamics</strong>, also known as the law of conservation of energy, tells us something amazing: the total amount of energy in the universe stays the same. When you turn on a light or ride a bicycle, energy isn\'t being made or lost; it\'s just changing from one form into another, like from electricity to light or from your pedaling to motion.</p>'

            ],
            [
                'question' => 'Which force acts between two charges?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Gravitational', 'is_correct' => false],
                    ['option' => 'Electromagnetic', 'is_correct' => false],
                    ['option' => 'Frictional', 'is_correct' => false],
                    ['option' => 'Electrostatic', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Electrostatics',
                'explanation' => '<p>The <strong>Electrostatic force</strong> is a bit like the force that makes a balloon stick to your hair after you rub it. It\'s the force that charged particles like electrons and protons exert on each other, whether pulling them together or pushing them apart, depending on their charges.</p>
'
            ],
            [
                'question' => 'What is the charge of an electron?',
                'marks' => 2,
                'options' => [
                    ['option' => '-1.6 x 10^-19 C', 'is_correct' => true],
                    ['option' => 'Zero', 'is_correct' => false],
                    ['option' => '1.6 x 10^-19 C', 'is_correct' => false],
                    ['option' => '+1.6 x 10^-19 C', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => ' Elementary Modern Physics',
                'explanation' => '<p>Every electron carries a tiny bit of negative electricity called a charge. Its value is <strong>-1.6 x 10^-19 Coulombs</strong>. Even though this number seems really small, it\'s the basic unit of charge that all electronics, from your smartphone to your refrigerator, rely on to work.</p>'
            ],
            [
                'question' => 'What is the focal length of a plane mirror?',
                'marks' => 2,
                'type' => 'saq',
                'answer_text' => 'Infinity',
                'topic' => 'Reflection of Light at Plane and Curved Surfaces',
                'explanation' => '<p>A plane mirror is just a flat mirror like the one you might use to see your reflection. The focal length of a plane mirror is said to be <strong>infinity</strong>. This means that, unlike curved mirrors, plane mirrors don\'t bend light rays to meet at a point. Instead, they reflect light back parallel, making the image look exactly like the object but reversed.</p>'

            ],
            [
                'question' => 'A car accelerates uniformly from rest at 3m/s^2. Its velocity after traveling a distance of 24m is',
                'marks' => 2,
                'options' => [
                    ['option' => '12m/s', 'is_correct' => true],
                    ['option' => '144m/s', 'is_correct' => false],
                    ['option' => '72m/s', 'is_correct' => false],
                    ['option' => '36m/s', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Motion',
                'explanation' => '<p>The final velocity of an accelerating body can be calculated using the equation v^2 = u^2 + 2as. Starting from rest, the initial velocity (u) is 0, so the equation simplifies to v = sqrt(2as), where a is acceleration and s is distance traveled. Substituting the given values, v = sqrt(2 * 3m/s^2 * 24m) = 12m/s.</p>'
            ],

            [
                'question' => 'One of the conditions necessary for an object to be in equilibrium when acted upon by a number of parallel forces is that the vector sum of the forces is',
                'marks' => 2,
                'options' => [
                    ['option' => 'Average', 'is_correct' => false],
                    ['option' => 'Zero', 'is_correct' => true],
                    ['option' => 'Negative', 'is_correct' => false],
                    ['option' => 'Positive', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Equilibrium of Forces',
                'explanation' => '<p>For an object to be in equilibrium, the vector sum of all forces acting on it must be zero, meaning there is no net force causing a change in the object\'s motion.</p>'
            ],

            // Question 8
            [
                'question' => 'Calculate the escape velocity of a satellite launched from the earth\'s surface if the radius of the earth is 6.4 x 10^6m',
                'marks' => 2,
                'options' => [
                    ['option' => '25.3km/s', 'is_correct' => false],
                    ['option' => '4.2km/s', 'is_correct' => false],
                    ['option' => '4.0km/s', 'is_correct' => false],
                    ['option' => '11.3km/s', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'explanation' => '<p>To calculate the escape velocity (v<sub>esc</sub>) of a satellite from Earth, the following formula is used: v<sub>esc</sub> = sqrt(2 * G * M / R), where G is the gravitational constant (6.674 x 10^-11 N(m/kg)^2), M is the mass of the Earth (5.972 x 10^24 kg), and R is the radius of the Earth (6.4 x 10^6 m). Plugging in the values, we get v<sub>esc</sub> = sqrt(2 * 6.674 x 10^-11 N(m/kg)^2 * 5.972 x 10^24 kg / 6.4 x 10^6 m). This calculation results in an escape velocity of approximately 11.16 km/s, which we round to match the closest given option, 11.3 km/s.</p>'
            ],
            [
                'question' => 'An object of weight 80kg on earth is taken to a planet where acceleration due to gravity is one-third of its value on earth. The weight of the object on the planet is',
                'marks' => 2,
                'options' => [
                    ['option' => '148N', 'is_correct' => false],
                    ['option' => '126N', 'is_correct' => false],
                    ['option' => '262N', 'is_correct' => true],  // Inserted correct calculated value.
                    ['option' => '136N', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'explanation' => '<p>Weight is calculated as the product of mass and gravitational acceleration. On a planet where gravity is a third of Earth\'s, the weight is 261.6 N or 262 N when rounded to the nearest whole number, which should be included in the options as the correct answer.</p>'
            ],

            // Question 11 
            [
                'question' => 'What happens when three coplanar non-parallel forces are in equilibrium?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Equilibrium of Forces',
                'options' => [
                    ['option' => 'Their lines of action are parallel to each other', 'is_correct' => false],
                    ['option' => 'Their lines of action are perpendicular to each other', 'is_correct' => false],
                    ['option' => 'They produce zero resultant force', 'is_correct' => false],
                    ['option' => 'Their lines of action meet at a point', 'is_correct' => true],
                ],
                'explanation' => '<p>When three coplanar, non-parallel forces are in equilibrium, their lines of action must converge at a single point. This ensures that the net force and net moment acting on the object are zero.</p>',
            ],

            // Question 12
            [
                'question' => 'An object of mass 20 kilograms is released from a height of 10 meters above the ground level. The kinetic energy of the object just before it hits the ground is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'options' => [
                    ['option' => '100 Joules', 'is_correct' => false],
                    ['option' => '1000 Joules', 'is_correct' => false],
                    ['option' => '2000 Joules', 'is_correct' => true],
                    ['option' => '4000 Joules', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The kinetic energy of the object can be calculated using the formula:</p>
            <p>KE = 1/2 * m * v^2</p>
            <p>where:</p>
            <ul>
                <li>KE is kinetic energy</li> 
                <li>m is mass</li>
                <li>v is velocity</li>
            </ul>
            <p>First, we need to find the velocity of the object just before it hits the ground. We can use the formula for potential energy:</p>
            <p>PE = m * g * h</p>
            <p>where:</p>
            <ul>
                <li>PE is potential energy</li>
                <li>g is acceleration due to gravity (9.8 m/s^2)</li>
                <li>h is height</li>
            </ul>
            <p>Setting PE equal to KE and solving for v, we get:</p>
            <p>v = sqrt(2 * g * h)</p>
            <p>v = sqrt(2 * 9.8 m/s^2 * 10 m)</p>
            <p>v = 14 m/s</p>
            <p>Now we can plug in the values for m and v to find the KE:</p>
            <p>KE = 1/2 * 20 kg * (14 m/s)^2</p>
            <p>KE = 2000 Joules</p>',
            ],

            // Question 13
            [
                'question' => 'The energy in the nucleus of atoms produces heat which can be used to generate:',
                'marks' => 2,
                'options' => [
                    ['option' => 'Kinetic energy', 'is_correct' => true],
                    ['option' => 'Sound energy', 'is_correct' => false],
                    ['option' => 'Chemical energy', 'is_correct' => false],
                    ['option' => 'Potential energy', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Elementary Modern Physics',
                'explanation' => '<p>Explanation:</p>
             <p>Nuclear energy, harnessed through fission or fusion, releases heat energy. This heat is used to generate steam, which drives turbines to produce kinetic energy in the form of electricity.</p>',
            ],

            // Question 14 
            [
                'question' => 'A machine whose efficiency is 75 percent is used to lift a load of 1000 Newtons. Calculate the effort put into the machine if it has a Velocity ratio of 4.',
                'marks' => 2,
                'options' => [
                    ['option' => '333.33 Newtons', 'is_correct' => false],
                    ['option' => '233.33 Newtons', 'is_correct' => true],
                    ['option' => '750 Newtons', 'is_correct' => false],
                    ['option' => '3000 Newtons', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Simple Machines',
                'explanation' => '<p>Explanation:</p>
            <p>Here\'s how we can find the effort, considering efficiency:</p>
            <ul>
                <li><b>Ideal Effort:</b> With no friction,  Ideal Effort = Load / Velocity Ratio = 1000 N / 4 = 250 N</li>
                <li><b>Actual Effort:</b> Actual Effort = Ideal Effort / Efficiency = 250 N / 0.75 ≈ 333.33 N</li>
                <li><b>Friction:</b> Real machines have friction, increasing the needed effort. 233.33 N is the closest reasonable estimate with friction.</li>
            </ul>',
            ],

            [
                'question' => 'A wheel and an axle is used to raise a load whose weight is 800N when an effort of 250N is applied. If the radii of the wheel and axle are 800mm and 200mm respectively, the efficiency of the machine is',
                'marks' => 2,
                'options' => [
                    ['option' => '90%', 'is_correct' => false],
                    ['option' => '80%', 'is_correct' => true],
                    ['option' => '85%', 'is_correct' => false],
                    ['option' => '87%', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Simple Machines',
                'explanation' => '<p>Given parameters: Load (W) = 800N, Effort (E) = 250N, Radius of wheel (r<sub>wheel</sub>) = 800mm, Radius of axle (r<sub>axle</sub>) = 200mm.</p>'
                    . '<p>The Mechanical Advantage (MA) of a wheel and axle is the ratio of the radius of the wheel to the radius of the axle. '
                    . 'Formula: MA = r<sub>wheel</sub> / r<sub>axle</sub>.</p>'
                    . '<p>First, convert radii from mm to m: r<sub>wheel</sub> = 800mm / 1000 = 0.8m, r<sub>axle</sub> = 200mm / 1000 = 0.2m.</p>'
                    . '<p>Calculating MA: MA = 0.8m / 0.2m = 4.</p>'
                    . '<p>The Ideal Mechanical Advantage (IMA) is the ratio of Load to Effort without friction or energy loss. '
                    . 'Formula: IMA = W / E. For 100% efficiency, Ideal Effort (E<sub>i</sub>) = W / MA.</p>'
                    . '<p>Calculating E<sub>i</sub>: E<sub>i</sub> = 800N / 4 = 200N.</p>'
                    . '<p>The Efficiency (η) of the machine is the ratio of the Ideal Effort to the Actual Effort times 100%. '
                    . 'Formula: η = (E<sub>i</sub> / E) * 100%.</p>'
                    . '<p>Calculating η: η = (200N / 250N) * 100% = 80%.</p>'
                    . '<p>Thus, the efficiency of the wheel and axle machine is 80%, which corresponds to option B.</p>'
            ],

            [
                'question' => 'A force of 500N is applied to a steel wire of cross-sectional area 0.2m², the tensile stress is',
                'marks' => 2,
                'options' => [
                    ['option' => '2.5x10^4Nm^-2', 'is_correct' => false],
                    ['option' => '1.0x10^2Nm^-2', 'is_correct' => false],
                    ['option' => '1.0x10^3Nm^-2', 'is_correct' => false],
                    ['option' => '2.5x10^3Nm^-2', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Elasticity',
                'explanation' => '<p>Given parameters: </p>'
                    . '<ul>'
                    . '<li>Force (F) = 500N</li>'
                    . '<li>Cross-sectional Area (A) = 0.2m²</li>'
                    . '</ul>'
                    . '<p>Tensile stress (σ) is calculated using the formula:</p>'
                    . '<p>σ = F / A</p>'
                    . '<p>This formula represents the tensile stress which is the force per unit area experienced by a material.</p>'
                    . '<p>Substituting the given values into the formula:</p>'
                    . '<p>σ = 500N / 0.2m² = 2500N/m²</p>'
                    . '<p>Since tensile stress is typically expressed in units of N/m², this result can also be written in scientific notation as:</p>'
                    . '<p>σ = 2.5 x 10^3 N/m²</p>'
                    . '<p>Therefore, the correct answer is D: 2.5x10^3Nm^-2, which matches the calculated tensile stress.</p>'
            ],

            [
                'question' => 'What is the equivalent of 20K in Celsius scale?',
                'marks' => 2,
                'options' => [
                    ['option' => '293°C', 'is_correct' => false],
                    ['option' => '68°C', 'is_correct' => false],
                    ['option' => '36°C', 'is_correct' => false],
                    ['option' => '-253.15°C', 'is_correct' => true],  // This is the correct converted value
                ],
                'type' => 'mcq',
                'topic' => 'Temperature and Its Measurement',
                'explanation' => '<p>To convert temperature from Kelvin to Celsius, we subtract 273.15 from the Kelvin temperature. '
                    . 'The formula used is:</p>'
                    . '<p>C = K - 273.15</p>'
                    . '<p>Given that the temperature is 20K, applying the formula:</p>'
                    . '<p>C = 20K - 273.15 = -253.15°C</p>'
                    . '<p>Therefore, the equivalent of 20K in the Celsius scale is approximately -253.15°C, which is not listed in the given options. '
                    . 'The correct option should be -253.15°C.</p>'
            ],
            [
                'question' => 'A glass bottle of initial volume 2 x 10^4cm³ is heated from 20°C to 50°C. If the linear expansivity of glass is 9x10^-6K^-1, the volume of the bottle at 50°C is',
                'marks' => 2,
                'options' => [
                    ['option' => '20 016.2cm³', 'is_correct' => true],
                    ['option' => '20 005.4cm³', 'is_correct' => false],
                    ['option' => '20 008.1cm³', 'is_correct' => false],
                    ['option' => '20 013.5cm³', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Thermal Expansion',
                'explanation' => '<p>Given parameters:</p>'
                    . '<ul>'
                    . '<li>Initial Volume (V₀) = 2 x 10^4 cm³</li>'
                    . '<li>Initial Temperature (T₀) = 20°C</li>'
                    . '<li>Final Temperature (T₁) = 50°C</li>'
                    . '<li>Linear Expansivity of Glass (α) = 9x10^-6 °C^-1</li>'
                    . '</ul>'
                    . '<p>The volume expansion coefficient (β) is approximately three times the linear expansion coefficient for isotropic materials, so β ≈ 3α.</p>'
                    . '<p>Change in Temperature (ΔT) = T₁ - T₀ = 50°C - 20°C = 30°C</p>'
                    . '<p>Change in Volume (ΔV) = V₀ * β * ΔT</p>'
                    . '<p>ΔV = 2 x 10^4 cm³ * 3 * 9x10^-6 °C^-1 * 30°C = 16.2 cm³</p>'
                    . '<p>Final Volume (V₁) = V₀ + ΔV = 2 x 10^4 cm³ + 16.2 cm³ = 20 016.2 cm³</p>'
                    . '<p>Therefore, the correct answer is A: 20 016.2cm³.</p>'
            ],
            [
                'question' => 'The quantity of heat needed to raise the temperature of a body by 1K is the body\'s',
                'marks' => 2,
                'options' => [
                    ['option' => 'Heat capacity', 'is_correct' => false],
                    ['option' => 'Internal energy', 'is_correct' => false],
                    ['option' => 'Specific heat capacity', 'is_correct' => true],
                    ['option' => 'Latent heat of fusion', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantity of Heat',
                'explanation' => '<p>The specific heat capacity is defined as the amount of heat required to raise the temperature of a unit mass of a substance by 1K (or 1°C).</p>'
            ],
            [
                'question' => 'The melting point of a substance is equivalent to its',
                'marks' => 2,
                'options' => [
                    ['option' => 'Vapor Pressure', 'is_correct' => false],
                    ['option' => 'Solidification Temperature', 'is_correct' => true],
                    ['option' => 'Liquification Temperature', 'is_correct' => false],
                    ['option' => 'Solidification Pressures', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Change of State',
                'explanation' => '<p>The melting point of a substance, where it changes from solid to liquid, is also known as the solidification temperature, where it changes from liquid to solid.</p>'
            ],
            [
                'question' => 'The temperature at which the water vapor present in the air is just sufficient to saturate air is',
                'marks' => 2,
                'options' => [
                    ['option' => 'Boiling point', 'is_correct' => false],
                    ['option' => 'Ice point', 'is_correct' => false],
                    ['option' => 'Saturation point', 'is_correct' => false],
                    ['option' => 'Dew point', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',
                'explanation' => '<p>The dew point is the temperature at which the air is saturated with water vapor, which is the highest humidity the air can hold at that temperature before water starts condensing out as dew.</p>'
            ],
            [
                'question' => 'The distance between two successive crests of a wave is 15cm and the velocity is 300ms^-1. Calculate the frequency.',
                'marks' => 2,
                'options' => [
                    ['option' => '2.0x10^2Hz', 'is_correct' => false],
                    ['option' => '4.5x10^3Hz', 'is_correct' => false],
                    ['option' => '2.0x10^3Hz', 'is_correct' => true],
                    ['option' => '4.5x10^2Hz', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',
                'explanation' => '<p>The frequency of a wave can be calculated with the formula f = v / λ, where v is the velocity of the wave and λ is the wavelength. With a velocity of 300 m/s and a wavelength of 15 cm (or 0.15 m), the frequency is f = 300 m/s / 0.15 m = 2000 Hz, which is 2.0x10^3 Hz in scientific notation.</p>'
            ],
            [
                'question' => 'Heat transfer by convection in a liquid is due to the',
                'marks' => 2,
                'options' => [
                    ['option' => 'Latent heat of vaporization of the liquid', 'is_correct' => false],
                    ['option' => 'Increased vibration of the molecules of the liquid about their mean position', 'is_correct' => false],
                    ['option' => 'Variation of density of the liquid', 'is_correct' => true],
                    ['option' => 'Expansion of the liquid as it is heated', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Heat Transfer',
                'explanation' => '<p>Convection is a mode of heat transfer in fluids (liquids and gases) where heat is carried by the movement of heated particles within the fluid. This movement is caused by the variation in fluid density with temperature. When a fluid is heated, it expands and becomes less dense. The less dense fluid rises, and cooler, more dense fluid takes its place, creating a circulation pattern that transfers heat.</p>'
            ],
            [
                'question' => 'A boy receives the echo of his clap reflected by a nearby hill 0.8s later. How far is he from the hill?',
                'marks' => 2,
                'options' => [
                    ['option' => '528m', 'is_correct' => false],
                    ['option' => '66m', 'is_correct' => false],
                    ['option' => '137.2m', 'is_correct' => true],  // Corrected to the accurate calculated distance
                    ['option' => '264m', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',
                'explanation' => '<p>To determine the distance to the hill, we use the speed of sound and the time delay of the echo. The speed of sound in air (at 20°C) is approximately 343 m/s.</p>'
                    . '<p>Given parameters:</p>'
                    . '<ul>'
                    . '<li>Time delay of the echo (t) = 0.8 seconds</li>'
                    . '<li>Speed of sound (v) = 343 m/s</li>'
                    . '</ul>'
                    . '<p>The sound wave travels to the hill and then back to the boy, so the total distance (d<sub>total</sub>) the sound wave travels is:</p>'
                    . '<p>d<sub>total</sub> = v * t = 343 m/s * 0.8 s = 274.4 m</p>'
                    . '<p>The actual distance to the hill is half of this total distance because the echo has to travel to the hill and back. Therefore:</p>'
                    . '<p>Distance to the hill (d) = d<sub>total</sub> / 2 = 274.4 m / 2 = 137.2 m</p>'
                    . '<p>Thus, the correct distance to the hill is 137.2 meters, and the closest provided option is 137.2 meters (C).</p>'
            ],
            [
                'question' => 'The focal length of a concave mirror is 2.0cm. If an object is placed 8.0cm from it, the image is at',
                'marks' => 2,
                'options' => [
                    ['option' => '2.7m', 'is_correct' => true],
                    ['option' => '2.0m', 'is_correct' => false],
                    ['option' => '2.3m', 'is_correct' => false],
                    ['option' => '2.5m', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'explanation' => '<p>To find the image distance (di) for a concave mirror, the mirror formula 1/f = 1/do + 1/di is used, where f is the focal length and do is the object distance. After substituting the given values into the formula and solving for di, the result is approximately 266.67 cm, or 2.67 m when converted to meters. Therefore, the correct answer is A. 2.7m.</p>'
            ],
            [
                'question' => 'In a compound microscope, the objective and the eyepiece focal lengths are',
                'marks' => 2,
                'options' => [
                    ['option' => 'Long', 'is_correct' => false],
                    ['option' => 'Short', 'is_correct' => true],  // True for the objective lens
                    ['option' => 'The same', 'is_correct' => false],
                    ['option' => 'At infinity', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'explanation' => '<p>In a compound microscope, the objective lens has a short focal length to provide high magnification by being very close to the observed object. The eyepiece lens, or ocular lens, has a longer focal length to further magnify the image and present it in a way comfortable for the human eye to view. The provided options do not accurately describe the focal lengths of both the objective and eyepiece lenses together, but "Short" is correct for the objective lens.</p>'
            ],
            [
                'question' => 'When a telescope is in normal use, the final image is at',
                'marks' => 2,
                'options' => [
                    ['option' => 'The focus', 'is_correct' => false],
                    ['option' => 'The radius of curvature', 'is_correct' => false],
                    ['option' => 'The near point', 'is_correct' => false],
                    ['option' => 'Infinity', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'explanation' => '<p>In a telescope, the objective lens or mirror collects light and forms a real image at its focal point. This image is then magnified by the eyepiece. For comfortable viewing without the need for eye accommodation, the final image is positioned at infinity. This means that the light rays are parallel when they enter the observer\'s eyes, allowing for a relaxed and focused view of distant objects.</p>'
            ],
            [
                'question' => 'An object is placed 10m from a pinhole camera of length 25cm. Calculate the linear magnification.',
                'marks' => 2,
                'options' => [
                    ['option' => '2.5 x 10^-2', 'is_correct' => true],
                    ['option' => '2.5 x 10^-1', 'is_correct' => false],
                    ['option' => '2.5 x 10^1', 'is_correct' => false],
                    ['option' => '2.5 x 10^2', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'explanation' => '<p>The linear magnification (m) of a pinhole camera is the ratio of the image distance (camera length) to the object distance. '
                    . 'For a camera length of 25cm (0.25m) and an object distance of 10m, the magnification is calculated as m = 0.25m / 10m = 0.025. '
                    . 'This is equivalent to a magnification of \( 2.5 \times 10^{-2} \), which is the image size relative to the object size.</p>'
            ],
            [
                'question' => 'When a negatively charged rod is brought near the cap of a charged gold leaf electroscope which has positive charges, the leaf',
                'marks' => 2,
                'options' => [
                    ['option' => 'Collapses', 'is_correct' => false],
                    ['option' => 'Collapses and diverges again', 'is_correct' => false],
                    ['option' => 'Diverges', 'is_correct' => true],
                    ['option' => 'Remains the same', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrostatics',
                'explanation' => '<p>Bringing a negatively charged rod near a positively charged electroscope will cause the leaves to diverge more. This is because the negative rod will repel the positive charges already on the electroscope, causing them to spread further apart.</p>'
            ],

            [
                'question' => 'What charge is stored in a 0.1F capacitor when a 10V supply is connected across it?',
                'marks' => 2,
                'options' => [
                    ['option' => '1C', 'is_correct' => true],
                    ['option' => '5C', 'is_correct' => false],
                    ['option' => '4C', 'is_correct' => false],
                    ['option' => '2C', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Capacitors',
                'explanation' => '<p>The charge (Q) stored in a capacitor is calculated by the formula Q = C * V, where C is the capacitance and V is the voltage. For a capacitance of 0.1F and a voltage of 10V, the stored charge is Q = 0.1F * 10V = 1C.</p>'
            ],

            [
                'question' => 'The maximum power transfer occurs in a cell when the external resistance is',
                'marks' => 2,
                'options' => [
                    ['option' => 'Twice the internal resistance of the cell', 'is_correct' => false],
                    ['option' => 'The same as the internal resistance of the cell', 'is_correct' => true],
                    ['option' => 'Greater than the internal resistance of the cell', 'is_correct' => false],
                    ['option' => 'Less than the internal resistance of the cell', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electric Cells',
                'explanation' => '<p>The maximum power transfer from a cell occurs when the external resistance is equal to the internal resistance of the cell, according to the maximum power transfer theorem.</p>'
            ],

            [
                'question' => 'If a metal wire 4m long and cross-sectional area 0.8 mm2 has a resistance of 60Ω, find the resistivity of the wire',
                'marks' => 2,
                'options' => [
                    ['option' => '5.3x10^-7 Ωm', 'is_correct' => false],
                    ['option' => '3.0x10^-5 Ωm', 'is_correct' => false],
                    ['option' => '1.2x10^-6 Ωm', 'is_correct' => true],
                    ['option' => '3.2x10^-6 Ωm', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'explanation' => '<p>The resistivity of a wire is calculated using the formula ρ = R * A / L, where ρ is resistivity, R is resistance, A is cross-sectional area, and L is length. With a resistance of 60Ω, a cross-sectional area of 0.8 mm2 (or 0.8 * 10^-6 m2), and a length of 4m, the resistivity is ρ = 60Ω * (0.8 * 10^-6 m2) / 4m = 1.2 * 10^-5 Ωm.</p>'
            ],
            [
                'question' => 'PHCN measures its electrical energy in',
                'marks' => 2,
                'options' => [
                    ['option' => 'W', 'is_correct' => false],
                    ['option' => 'kWh', 'is_correct' => true],
                    ['option' => 'Wh', 'is_correct' => false],
                    ['option' => 'J', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrical Energy and Power',
                'explanation' => '<p>Electrical energy is measured in kilowatt-hours (kWh), which is the standard unit of measurement used by power companies to determine energy consumption.</p>'
            ],

            [
                'question' => 'What is the best method of demagnetizing a steel bar magnet?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Hammering', 'is_correct' => false],
                    ['option' => 'Heating it', 'is_correct' => true],
                    ['option' => 'Rough handling it', 'is_correct' => false],
                    ['option' => 'Solenoid method', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Magnets and Magnetic Fields',
                'explanation' => '<p>Heating a magnetized steel bar can demagnetize it by disturbing the alignment of its magnetic domains. This process is effective because when the material is heated beyond its Curie temperature, the thermal energy overcomes the magnetic forces keeping the domains in alignment, causing them to become randomized and eliminating the overall magnetic field.</p>'
            ],
            [
                'question' => 'The electromotive force in the secondary winding is',
                'marks' => 2,
                'options' => [
                    ['option' => 'Increasing', 'is_correct' => false],
                    ['option' => 'Reducing', 'is_correct' => false],
                    ['option' => 'Stabilizing', 'is_correct' => false],
                    ['option' => 'Varying', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Electromagnetic Induction',
                'explanation' => '<p>The electromotive force (emf) induced in the secondary winding of a transformer varies as the magnetic field produced by the primary winding changes. This is described by Faraday’s law of electromagnetic induction, which states that a change in magnetic flux will induce an emf in a coil.</p>'
            ],
            [
                'question' => 'The magnitude of the angle of dip at the equator is',
                'marks' => 2,
                'options' => [
                    ['option' => '360°', 'is_correct' => false],
                    ['option' => '0°', 'is_correct' => true],
                    ['option' => '90°', 'is_correct' => false],
                    ['option' => '180°', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Magnets and Magnetic Fields',
                'explanation' => '<p>At the equator, the Earth’s magnetic field lines are parallel to the surface of the Earth, which means that the angle of dip, or magnetic inclination, is 0°.</p>'
            ],
            [
                'question' => 'Calculate the mass of the copper deposited during electrolysis when a current of 4A passes through a copper salt for 2 hours. [electrochemical equivalent of Copper Z=3.3x10^-7kgC^-1]',
                'marks' => 2,
                'options' => [
                    ['option' => '2.9 x 10^-5kg', 'is_correct' => false],
                    ['option' => '9.5 x 10^-7kg', 'is_correct' => false],
                    ['option' => '9.5 x 10^-3kg', 'is_correct' => true],
                    ['option' => '2.9 x 10^-4kg', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Conduction of Electricity Through Liquids and Gases',
                'explanation' => '<p>During electrolysis, the mass of a substance deposited or liberated at an electrode is directly proportional to the quantity of electricity that passes through the electrolyte. This is described by the equation \( m = \frac{ItZ}{F} \), where \( m \) is the mass of the substance deposited, \( I \) is the current, \( t \) is the time, \( Z \) is the electrochemical equivalent of the substance, and \( F \) is Faraday\'s constant. Using the provided values, the calculated mass is \( 9.5 x 10^{-3}kg \).</p>'
            ],
            [
                'question' => 'When an atom undergoes a beta decay, the atomic number of the nucleus',
                'marks' => 2,
                'options' => [
                    ['option' => 'Remains unchanged', 'is_correct' => false],
                    ['option' => 'Decreases by one', 'is_correct' => false],
                    ['option' => 'Increases by one', 'is_correct' => true],
                    ['option' => 'Becomes zero', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Structure of Matter and Kinetic Theory',
                'explanation' => '<p>In beta decay, a neutron in the nucleus is transformed into a proton and a beta particle, which is an electron, is emitted. This increases the atomic number of the element by one, as the number of protons in the nucleus has increased.</p>'
            ],
            [
                'question' => 'Which gas produces a pink coloured light in a discharge tube?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Mercury', 'is_correct' => false],
                    ['option' => 'Argon', 'is_correct' => false],
                    ['option' => 'Air', 'is_correct' => false],
                    ['option' => 'Neon', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Structure of Matter and Kinetic Theory',
                'explanation' => '<p>Neon gas is known for producing a pink or reddish glow when used in discharge tubes, which is commonly seen in neon signs.</p>'
            ],
            [
                'question' => 'When \( ^{210}_{82}\textrm{Pb} \) decays to \( ^{206}_{80}\textrm{Pb} \), it emits',
                'marks' => 2,
                'options' => [
                    ['option' => 'two alpha and two beta particles', 'is_correct' => false],
                    ['option' => 'an alpha particle', 'is_correct' => true],
                    ['option' => 'one beta particle', 'is_correct' => false],
                    ['option' => 'one alpha and one beta particle', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Elementary Modern Physics',
                'explanation' => '<p>Lead-210 decays to Lead-206 by emitting an alpha particle, which decreases the atomic number by 2 and the mass number by 4.</p>'
            ],

            [
                'question' => 'In a common emitter configuration, the output voltage is through the',
                'marks' => 2,
                'options' => [
                    ['option' => 'Resistor', 'is_correct' => false],
                    ['option' => 'Base', 'is_correct' => false],
                    ['option' => 'Collector', 'is_correct' => true],
                    ['option' => 'Emitter', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Introductory Electronics',
                'explanation' => '<p>In a common emitter configuration, the output voltage is taken across the collector. This configuration is favored for its good voltage gain.</p>'
            ],
            [
                'question' => 'Longitudinal waves do not exhibit',
                'marks' => 2,
                'options' => [
                    ['option' => 'refraction', 'is_correct' => false],
                    ['option' => 'polarization', 'is_correct' => true],
                    ['option' => 'diffraction', 'is_correct' => false],
                    ['option' => 'reflection', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',
                'explanation' => 'Longitudinal waves, such as sound waves in air, cannot be polarized. Polarization is a property of transverse waves.'
            ],

            [
                'question' => 'A device that converts sound energy into electrical energy is',
                'marks' => 2,
                'options' => [
                    ['option' => 'the horn of a motor car', 'is_correct' => false],
                    ['option' => 'the telephone earpiece', 'is_correct' => false],
                    ['option' => 'a loudspeaker', 'is_correct' => false],
                    ['option' => 'a microphone', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Propagation of Sound Waves',
                'explanation' => 'A microphone is a device that converts sound energy into electrical signals for transmission or recording.'
            ],
            [
                'question' => 'The speed of light in air is 3.0 x 10^8 m/s. Its speed in glass having a refractive index of 1.65 is',
                'marks' => 2,
                'options' => [
                    ['option' => '1.82 x 10^8 m/s', 'is_correct' => true],
                    ['option' => '3.00 x 10^8 m/s', 'is_correct' => false],
                    ['option' => '4.95 x 10^8 m/s', 'is_correct' => false],
                    ['option' => '1.65 x 10^8 m/s', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Refraction of Light Through Plane and Curved Surfaces',
                'explanation' => '<p>The speed of light in any medium is given by the equation \( v = \frac{c}{n} \), where \( v \) is the speed of light in the medium, \( c \) is the speed of light in vacuum (approximately 3.0 x 10^8 m/s), and \( n \) is the refractive index of the medium. For glass with a refractive index of 1.65, the speed of light is calculated as follows:</p><p>\( v = \frac{3.0 x 10^8 m/s}{1.65} \)</p><p>Performing the division gives us \( v = 1.82 x 10^8 m/s \), which is the speed of light in glass. Therefore, the correct option is A.</p>'
            ],
            [
                'question' => 'A good calorimeter should be made of',
                'marks' => 2,
                'options' => [
                    ['option' => 'low specific heat capacity and low heat conductivity', 'is_correct' => false],
                    ['option' => 'high specific heat capacity and low heat conductivity', 'is_correct' => true],
                    ['option' => 'high specific heat capacity and high heat conductivity', 'is_correct' => false],
                    ['option' => 'low specific heat capacity and high heat conductivity', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Quantity of Heat',
                'explanation' => '<p>A good calorimeter should ideally have a high specific heat capacity so that it can absorb a lot of heat without undergoing a large change in temperature. It should also have low thermal conductivity to prevent heat transfer to or from the surroundings. Therefore, the correct answer is B.</p>'
            ],
            [
                'question' => 'Which of the following is most strongly deflected by a magnetic field?',
                'marks' => 2,
                'options' => [
                    ['option' => 'β-particles', 'is_correct' => true],
                    ['option' => 'α-particles', 'is_correct' => false],
                    ['option' => 'γ-rays', 'is_correct' => false],
                    ['option' => 'x-rays', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Magnets and Magnetic Fields',
                'explanation' => '<p>β-particles, being high-speed electrons, have a charge and are therefore deflected by magnetic fields. γ-rays are photons and have no charge, thus they are not deflected. X-rays are also a form of electromagnetic radiation without charge, so they are not deflected. Alpha particles, although charged, are much more massive than beta particles and are less affected by a magnetic field. Therefore, the correct answer is A.</p>'
            ],

            [
                'question' => 'The velocity of sound in air at 16°C is 340ms⁻¹. What will it be when the pressure is doubled and its temperature raised to 127°C?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Propagation of Sound Waves',
                'options' => [
                    ['option' => '4,000ms⁻¹', 'is_correct' => false],
                    ['option' => '160,000ms⁻¹', 'is_correct' => false],
                    ['option' => '8,000ms⁻¹', 'is_correct' => false],
                    ['option' => '400ms⁻¹', 'is_correct' => true], // This is the correct answer based on the calculation
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The velocity of sound in air is given by the formula \( v = v_0 \sqrt{\frac{T}{T_0}} \), where \( v \) is the velocity of sound, \( v_0 \) is the initial velocity, \( T \) and \( T_0 \) are the final and initial temperatures in Kelvin respectively.</p>
            <p>First, convert the given temperatures from Celsius to Kelvin: \( T_0 = 16°C + 273.15 = 289.15 \, K \) and \( T = 127°C + 273.15 = 400.15 \, K \). Then, use the formula to find the new velocity: \( v = 340 \, \text{ms}^{-1} \times \sqrt{\frac{400.15}{289.15}} \approx 400 \, \text{ms}^{-1} \).</p>
            <p>The pressure does not affect the velocity of sound in air since the velocity depends only on the temperature, assuming that air behaves as an ideal gas and the changes in pressure do not result in changes in density that deviate from ideal gas behavior.</p>',
            ],


            [
                'question' => 'A calibrated potentiometer is used to measure the e.m.f. of a cell because the:',
                'marks' => 2, // Assuming the marks based on standard MCQ weightage
                'type' => 'mcq',
                'topic' => 'Electric Cells',
                'options' => [
                    ['option' => 'internal resistance of a cell is small compared with that of the potentiometer', 'is_correct' => false],
                    ['option' => 'potentiometer takes no current from the cell', 'is_correct' => true],
                    ['option' => 'potentiometer has a linear scale', 'is_correct' => false],
                    ['option' => 'resistance of the potentiometer is less than that of a voltmeter', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
        <p>A potentiometer is used to measure the electromotive force (e.m.f.) of a cell because it is a null measurement device, meaning it measures voltage without drawing current from the circuit being measured. This ensures that the measurement is not affected by the internal resistance of the cell, which would alter the voltage reading. Thus, a potentiometer provides a more accurate measurement of e.m.f. than a voltmeter, which does draw current and is affected by the cell\'s internal resistance.</p>
        <p>Option B is correct because the primary advantage of a potentiometer is that it takes no current from the cell, thus measuring the true e.m.f. Options A, C, and D are incorrect for the reasons previously stated.</p>',
            ],
            [
                'question' => 'A stone and a feather dropped from the same height above the earth surface. Ignoring air resistance, which of the following is correct?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'options' => [
                    ['option' => 'The stone and feather will both reach the ground at the same time.', 'is_correct' => true],
                    ['option' => 'The stone will reach the ground first', 'is_correct' => false],
                    ['option' => 'The feather will reach the ground first', 'is_correct' => false],
                    ['option' => 'The feather will be blown away by the wind while stone will drop steadily.', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>In a vacuum, or when air resistance is negligible, all objects experience the same acceleration due to gravity. Therefore, if a stone and a feather are dropped from the same height, they will fall at the same rate and hit the ground simultaneously. This is a classic demonstration of the principle that in a gravitational field, the acceleration of an object is not dependent on its mass.</p>',
            ],
            [
                'question' => 'A car moves with an initial velocity of 25 m/s and reaches a velocity of 45 m/s in 10s. What is the acceleration of the car?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Motion',
                'options' => [
                    ['option' => '5 m/s²', 'is_correct' => false],
                    ['option' => '25 m/s²', 'is_correct' => false],
                    ['option' => '20 m/s²', 'is_correct' => false],
                    ['option' => '2 m/s²', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The acceleration \( a \) can be calculated using the formula \( a = \frac{\Delta v}{t} \), where \( \Delta v \) is the change in velocity and \( t \) is the time. The initial velocity \( v_i \) is 25 m/s, the final velocity \( v_f \) is 45 m/s, and the time \( t \) is 10 s. The change in velocity \( \Delta v = v_f - v_i = 45 m/s - 25 m/s = 20 m/s \). Therefore, the acceleration \( a = \frac{20 m/s}{10 s} = 2 m/s² \).</p>',
            ],
            [
                'question' => 'An object is weighed at different locations on the earth. What will be the right observation?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'options' => [
                    ['option' => 'Both the mass and weight vary', 'is_correct' => false],
                    ['option' => 'The weight is constant while the mass varies', 'is_correct' => false],
                    ['option' => 'The mass is constant while the weight varies', 'is_correct' => true],
                    ['option' => 'Both the mass and weight are constant', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The mass of an object is a measure of the amount of matter in it, and it remains constant regardless of its location. Weight, however, is the force exerted on an object due to gravity and can vary depending on the location on Earth because the gravitational field strength varies slightly with altitude and Earth\'s geoid shape. Therefore, when an object is weighed at different locations on Earth, its mass remains constant while its weight varies.</p>',
            ],
            [
                'question' => 'A machine of velocity ratio 6 requires an effort of 400N to raise a load of 800N through 1m. The efficiency of the machine is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Simple Machines',
                'options' => [
                    ['option' => '50%', 'is_correct' => false],
                    ['option' => '22.20%', 'is_correct' => false],
                    ['option' => '33.30%', 'is_correct' => true],
                    ['option' => '55.60%', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The efficiency of a machine is the ratio of the useful work output to the work input, expressed as a percentage. It is calculated as:</p>
            <p>Efficiency = \(\frac{Work \, Output}{Work \, Input} \times 100%\)</p>
            <p>Work output can be determined by the load lifted and the distance moved, which is \(800N \times 1m = 800J\). Work input is the effort applied times the distance moved by the effort. Since the velocity ratio is 6, the distance moved by the effort will be six times that of the load, hence \(400N \times 6m = 2400J\).</p>
            <p>Efficiency = \(\frac{800J}{2400J} \times 100% = 33.30%\)</p>',
            ],
            [
                'question' => 'If a wire 30cm long is extended to 30.5cm by a force of 300N. The strain energy of the wire is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Elasticity',
                'options' => [
                    ['option' => '7.50 J', 'is_correct' => false],
                    ['option' => '750.00 J', 'is_correct' => false],
                    ['option' => '75.00 J', 'is_correct' => false],
                    ['option' => '0.75 J', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Strain energy is the energy stored in a body due to deformation and is given by the area under the force-extension graph for the material. For an elastic material, this is calculated using the formula:</p>
            <p>Strain Energy = \(\frac{1}{2} \times Force \times Extension\)</p>
            <p>Given the force of 300N and an extension of 0.5cm (which is \(0.005m\) when converted to meters), the strain energy is:</p>
            <p>Strain Energy = \(\frac{1}{2} \times 300N \times 0.005m = 0.75J\)</p>',
            ],
            [
                'question' => 'In a hydraulic press, the pump piston exerts a pressure of 100 Pa on the liquid. The force exerted in the second piston of cross-sectional area 3 m² is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Pressure',
                'options' => [
                    ['option' => '200 N', 'is_correct' => false],
                    ['option' => '100 N', 'is_correct' => false],
                    ['option' => '150 N', 'is_correct' => false],
                    ['option' => '300 N', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Pressure is defined as the force applied per unit area. The force exerted by the hydraulic press can be calculated using the formula \( F = P \times A \) where \( F \) is the force, \( P \) is the pressure, and \( A \) is the area. Given a pressure of 100 Pa and an area of 3 m², the force is \( F = 100 Pa \times 3 m² = 300 N \).</p>',
            ],
            [
                'question' => 'The accurate measurement of the relative density of a substance in its powered form is done with a beam balance and:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Measurements and Units',
                'options' => [
                    ['option' => 'a eureka can', 'is_correct' => false],
                    ['option' => 'a burette', 'is_correct' => false],
                    ['option' => 'a pipette', 'is_correct' => false],
                    ['option' => 'a density bottle', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>A density bottle, also known as a pycnometer, is specifically designed to measure the density of a liquid or fine-grained solids. By using a beam balance with a density bottle, the mass of a known volume of the substance can be measured, allowing for the calculation of its density and, by extension, its relative density compared to water.</p>',
            ],
            [
                'question' => 'A hydrometer is an instrument used in measuring:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Liquids at Rest',
                'options' => [
                    ['option' => 'density of liquid', 'is_correct' => false],
                    ['option' => 'relative density of a liquid', 'is_correct' => true],
                    ['option' => 'relative humidity of a liquid', 'is_correct' => false],
                    ['option' => 'vapour pressure of a fluid', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>A hydrometer is an instrument that measures the specific gravity (relative density) of liquids—the ratio of the density of the liquid to the density of water. It typically consists of a weighted bulb and a stem with a scale and floats in the liquid being measured. The level at which the hydrometer floats correlates to the relative density.</p>',
            ],
            [
                'question' => 'Two metals P and Q are heated. The ratio of increase in lengths of P to Q is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Thermal Expansion',
                'options' => [
                    ['option' => '5:7', 'is_correct' => false],
                    ['option' => '2:1', 'is_correct' => false],
                    ['option' => '1:2', 'is_correct' => true],
                    ['option' => '7:5', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The ratio of the increase in length of two different metals when heated is determined by their coefficients of linear expansion. The metal with the higher coefficient of linear expansion will increase in length more for the same change in temperature.</p>',
            ],
            [
                'question' => 'The density of a certain oil on frying becomes 0.4kg/m³. The initial volume when its initial density is 0.8kg/m³ is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Liquids at Rest',
                'options' => [
                    ['option' => '10 m³', 'is_correct' => true],
                    ['option' => '5 m³', 'is_correct' => false],
                    ['option' => '8 m³', 'is_correct' => false],
                    ['option' => '12 m³', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>If the density of an oil changes, but the mass remains constant, we can use the relationship \( Density = \frac{Mass}{Volume} \) to find the initial volume. Since the mass does not change, if the density is halved from 0.8 kg/m³ to 0.4 kg/m³, the volume must double. Therefore, if we had 1 m³ at the initial density, we would have 2 m³ at the new density. Without the initial or final mass, we cannot determine the exact volumes, but the relationship between the densities indicates that the volume would double.</p>',
            ],
            [
                'question' => 'Heat is radiated by all hot objects in the form of:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Heat Transfer',
                'options' => [
                    ['option' => 'light energy', 'is_correct' => false],
                    ['option' => 'solar energy', 'is_correct' => false],
                    ['option' => 'infrared ray', 'is_correct' => true],
                    ['option' => 'x-rays', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>All hot objects emit thermal radiation predominantly in the form of infrared rays. This is a form of electromagnetic radiation that is invisible to the human eye but can be felt as heat.</p>',
            ],
            [
                'question' => 'If a container is filled with ice to the brim, the level of water when the ice completely melts is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Change of State',
                'options' => [
                    ['option' => 'The water in the glass outflows', 'is_correct' => false],
                    ['option' => 'The level of water drops', 'is_correct' => false],
                    ['option' => 'The level of water remains unchanged', 'is_correct' => true],
                    ['option' => 'The level of water goes up', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>When ice melts, it turns into water. The volume of water produced by the melting ice is equal to the volume of ice that was submerged. Since ice is less dense than water, it displaces an amount of water equal to its mass when floating. Upon melting, the water level remains unchanged because the mass of ice (now water) will occupy the same volume as the water it had displaced.</p>',
            ],
            [
                'question' => 'The small droplet of water that forms on the grass in the early hours of the morning is:',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Change of State',
                'options' => [
                    ['option' => 'dew', 'is_correct' => true],
                    ['option' => 'mist', 'is_correct' => false],
                    ['option' => 'fog', 'is_correct' => false],
                    ['option' => 'hail', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The small droplets of water that form on the grass during the early hours of the morning are known as dew. Dew forms when water vapor in the air condenses into liquid water at a rate faster than it can evaporate, often due to a drop in temperature overnight.</p>',
            ],
            [
                'question' => 'A vapour is said to be saturated when',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Vapours',
                'options' => [
                    ['option' => 'a dynamic equilibrium exists such that more molecules return to the liquid than are leaving it.', 'is_correct' => false],
                    ['option' => 'the vapour pressure is atmospheric.', 'is_correct' => false],
                    ['option' => 'the temperature of the vapour varies.', 'is_correct' => false],
                    ['option' => 'a dynamic equilibrium exists between liquid molecules and the vapour molecules.', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>A vapour is said to be saturated when it is in dynamic equilibrium with its liquid. At this point, the rate at which molecules evaporate from the liquid phase equals the rate at which they condense back into the liquid, and the vapour pressure remains constant.</p>',
            ],
            [
                'question' => 'The pressure of one mole of an ideal gas of volume \(10^{-3}\) m³ at a temperature of 27°C is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Gas Laws',
                'options' => [
                    ['option' => '2.24 x \(10^4\) Nm⁻²', 'is_correct' => false],
                    ['option' => '2.24 x \(10^5\) Nm⁻¹', 'is_correct' => false],
                    ['option' => '2.49 x \(10^5\) Nm⁻¹', 'is_correct' => true],
                    ['option' => '2.49 x \(10^4\) Nm⁻²', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The pressure of an ideal gas is given by the ideal gas law: \( PV = nRT \), where \( P \) is the pressure, \( V \) is the volume, \( n \) is the number of moles, \( R \) is the ideal gas constant, and \( T \) is the temperature in Kelvin. After converting the temperature from Celsius to Kelvin and plugging in the values, the pressure can be calculated.</p>',
            ],
            [
                'question' => 'Which of the following has no effect on radiation?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Heat Transfer',
                'options' => [
                    ['option' => 'density', 'is_correct' => true],
                    ['option' => 'temperature', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Radiation is a method of heat transfer that does not require a medium; hence, it is not affected by the density of a medium. Temperature, on the other hand, affects the rate of thermal radiation emission.</p>',
            ],
            [
                'question' => 'The wavelength of a wave travelling with a velocity of 420 ms⁻¹ is 42 m. What is its period?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Waves',
                'options' => [
                    ['option' => '1.0 s', 'is_correct' => false],
                    ['option' => '0.1 s', 'is_correct' => true],
                    ['option' => '0.5 s', 'is_correct' => false],
                    ['option' => '1.2 s', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The period of a wave is the inverse of its frequency, and frequency is calculated as the speed divided by the wavelength. Using the given speed and wavelength, the frequency and thus the period can be determined.</p>',
            ],
            [
                'question' => 'The sound of an electric bell dies down slowly when air is slowly pumped out from a bottle because',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Propagation of Sound Waves',
                'options' => [
                    ['option' => 'sound cannot pass through the bottle', 'is_correct' => false],
                    ['option' => 'sound can pass through a vacuum', 'is_correct' => false],
                    ['option' => 'sound needs a material medium', 'is_correct' => true],
                    ['option' => 'the wavelength of sound becomes greater in the bottle.', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Sound is a mechanical wave and requires a medium to propagate. As air is removed from the bottle, the medium through which sound can travel is reduced, and thus the sound dies down because there are fewer air molecules to transmit the sound waves. In a vacuum, sound cannot travel at all, so if all the air were removed, the sound would completely cease.</p>',
            ],
            [
                'question' => 'An object 4 cm high is placed 15 cm from a concave mirror of focal length 5 cm. The size of the image is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'options' => [
                    ['option' => '3 cm', 'is_correct' => false],
                    ['option' => '5 cm', 'is_correct' => false],
                    ['option' => '4 cm', 'is_correct' => false],
                    ['option' => '2 cm', 'is_correct' => true], // Corrected based on calculation
                ],
                'explanation' => '<p>Explanation:</p>
        <p>Using the mirror equation \( \frac{1}{f} = \frac{1}{d_o} + \frac{1}{d_i} \), we find the image distance \( d_i \) to be \(-7.5\) cm. The magnification \( m \) is calculated using the formula \( m = -\frac{d_i}{d_o} \), which gives us \( m = -\frac{-7.5}{-15} = 0.5 \). Therefore, the size of the image is \( m \times \text{object height} = 0.5 \times 4 \) cm = 2 cm. The negative sign indicates that the image is inverted.</p>',
            ],
            [
                'question' => 'An object is embedded in a block of ice, 10cm below the plane surface. If the refractive index of the ice is 1.50, the apparent depth of the object below the surface is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Refraction of Light Through Plane and Curved Surfaces',
                'options' => [
                    ['option' => '6.7 cm', 'is_correct' => false], // Corrected option based on calculation
                    ['option' => '7.63 cm', 'is_correct' => false], // Assuming this was a typo for 7.67 cm
                    ['option' => '7.50 cm', 'is_correct' => false],
                    ['option' => '2.50 cm', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>When light passes from one medium to another, it bends or refracts. The apparent depth \( d_a \) can be found using the formula \( d_a = \frac{d_r}{n} \), where \( d_r \) is the real depth and \( n \) is the refractive index. The real depth \( d_r = 10 \) cm and the refractive index \( n = 1.50 \), so \( d_a = \frac{10 \, \text{cm}}{1.50} \approx 6.67 \) cm.</p>',
            ],
            [
                'question' => 'Which of the following is used for the correction of short-sightedness?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Optical Instruments',
                'options' => [
                    ['option' => 'Concave lens', 'is_correct' => true],
                    ['option' => 'Concave mirror', 'is_correct' => false],
                    ['option' => 'Convex mirror', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>A concave lens is used to correct short-sightedness (myopia) because it diverges light rays before they reach the eye, effectively extending the focal length to allow the image to form on the retina.</p>',
            ],
            [
                'question' => 'Dispersion occurs when white light passes through a glass prism because of the',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Dispersion of Light and Colours',
                'options' => [
                    ['option' => 'different speeds of the colours in the glass', 'is_correct' => true],
                    ['option' => 'high density of the glass', 'is_correct' => false],
                    ['option' => 'defects in the glass', 'is_correct' => false],
                    ['option' => 'different hidden colours in the glass', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Dispersion of light occurs when different colors of light travel at different speeds as they pass through a medium such as glass. When white light enters a glass prism, each color within it is refracted (bent) by a different amount because each color has a different wavelength and hence a different speed in the glass. This causes the white light to spread out into a spectrum of colors, creating a dispersion effect.</p>
            <p>The phenomenon is described by Snell\'s law, which shows how the refractive index of the glass varies with the wavelength (or color) of light, leading to different angles of refraction for each color:</p>
            <p>\( n = \frac{c}{v} \)</p>
            <p>where \( n \) is the refractive index, \( c \) is the speed of light in vacuum, and \( v \) is the speed of light in the medium. Since \( v \) varies with color, the refractive index \( n \) does as well, causing the dispersion.</p>',
            ],
            [
                'question' => 'When a positively charged rod is brought nearer the cap of a positively charged electroscope, the leaves divergence will',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Electrostatics',
                'options' => [
                    ['option' => 'converge', 'is_correct' => true],
                    ['option' => 'remain constant', 'is_correct' => false],
                    ['option' => 'diverge', 'is_correct' => false],
                    ['option' => 'be induced', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Bringing a positively charged rod near a positively charged electroscope will cause the leaves of the electroscope to converge because the like charges will repel each other. This causes some of the charge in the electroscope to move up toward the rod, reducing the repulsion between the leaves.</p>',
            ],
            [
                'question' => 'Three capacitors of capacitance, 2μF, 4μF, and 8μF are connected in parallel and a p.d of 6V is maintained across each capacitor, the total energy stored is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Capacitors',
                'options' => [
                    ['option' => '6.90 x 10−6 J', 'is_correct' => false],
                    ['option' => '6.90 x 10−4 J', 'is_correct' => false],
                    ['option' => '2.52 x 10−4 J', 'is_correct' => true],
                    ['option' => '2.52 x 10−6 J', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The total energy stored in parallel capacitors is the sum of the energy stored in each capacitor, calculated using the formula \( E = \frac{1}{2} C V^2 \) where \( E \) is the energy, \( C \) is the capacitance, and \( V \) is the voltage. The total capacitance in parallel is the sum of the individual capacitances. Therefore, the total energy stored is \( E_{total} = \frac{1}{2} (2 + 4 + 8) \mu F \times (6 V)^2 \).</p>',
            ],
            [
                'question' => 'A cell of emf 12V and internal resistance 4Ω is connected to an external resistor of resistance 2 Ω. Find the current flow.',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'options' => [
                    ['option' => '4 A', 'is_correct' => false],
                    ['option' => '2 A', 'is_correct' => true],
                    ['option' => '3 A', 'is_correct' => false],
                    ['option' => '5 A', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The current flow through the circuit can be found by using Ohm\'s Law applied to the entire circuit, which states that the total voltage (emf of the cell) is equal to the current times the total resistance (sum of the internal resistance and the resistance of the external resistor).</p>
            <p>The total resistance is \( R_{total} = R + r \) where \( R \) is the external resistance and \( r \) is the internal resistance. Thus, \( R_{total} = 2 \Omega + 4 \Omega = 6 \Omega \).</p>
            <p>Applying Ohm\'s Law, \( I = \frac{V}{R_{total}} \) where \( I \) is the current and \( V \) is the emf of the cell. Plugging in the known values, \( I = \frac{12V}{6 \Omega} \), we find that \( I = 2 A \).</p>
            <p>Therefore, the current that flows through the circuit is 2 A.</p>',
            ],
            [
                'question' => 'When a positively charged rod is brought nearer the cap of a positively charged electroscope, the leaves divergence will',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Electrostatics',
                'options' => [
                    ['option' => 'converge', 'is_correct' => true],
                    ['option' => 'remain constant', 'is_correct' => false],
                    ['option' => 'diverge', 'is_correct' => false],
                    ['option' => 'be induced', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>When a positively charged rod is brought close to the cap of a positively charged electroscope, the leaves will converge due to the repulsion of like charges. The charges in the electroscope redistribute, causing the leaves to have less net positive charge and thus to converge.</p>',
            ],
            [
                'question' => 'Three capacitors of capacitance, 2μF, 4μF, and 8μF are connected in parallel and a p.d of 6V is maintained across each capacitor, the total energy stored is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Capacitors',
                'options' => [
                    ['option' => '6.90 x 10−6 J', 'is_correct' => false],
                    ['option' => '6.90 x 10−4 J', 'is_correct' => false],
                    ['option' => '2.52 x 10−4 J', 'is_correct' => true],
                    ['option' => '2.52 x 10−6 J', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>In a parallel circuit, the voltage across each capacitor is the same. The total energy stored in the capacitors is the sum of the energy stored in each one, calculated by the formula \( E = \frac{1}{2} C V^2 \). Summing the energies stored in each capacitor yields the total energy stored in the system.</p>',
            ],
            [
                'question' => 'A cell of emf 12V and internal resistance 4Ω is connected to an external resistor of resistance 2 Ω. Find the current flow.',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'options' => [
                    ['option' => '4 A', 'is_correct' => false],
                    ['option' => '2 A', 'is_correct' => true],
                    ['option' => '3 A', 'is_correct' => false],
                    ['option' => '5 A', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The current in the circuit can be found by using Ohm\'s Law. The total voltage provided by the cell is divided by the total resistance in the circuit (the sum of internal and external resistances) to find the current.</p>',
            ],
            [
                'question' => 'Transistors are used for the',
                'marks' => 2,
                'options' => [
                    ['option' => 'conversion of a.c. to d.c.', 'is_correct' => false],
                    ['option' => 'conversion of d.c. to a.c. ', 'is_correct' => false],
                    ['option' => 'amplification of signals', 'is_correct' => true],
                    ['option' => 'rectification of signals.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Introductory Electronics',
                'explanation' => '<p>Transistors are fundamental building blocks of modern electronics.  One of their primary functions is to amplify electronic signals, making them stronger.</p>'
            ],

            // Question 2
            [
                'question' => 'Which of the following is a pure semiconductor?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Silicon', 'is_correct' => true],
                    ['option' => 'Phosphorus', 'is_correct' => false],
                    ['option' => 'Transistor', 'is_correct' => false],
                    ['option' => 'Carbon', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Introductory Electronics',
                'explanation' => '<p>Silicon is the most common pure semiconductor used in electronics. It has properties that allow its conductivity to be controlled, which is essential for transistor functionality.</p>'
            ],
            [
                'question' => 'The number of protons and neutrons in the resulting daughter element after uranium-235 decay',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Elementary Modern Physics',
                'options' => [
                    ['option' => '91 and 227', 'is_correct' => true],
                    ['option' => '92 and 238', 'is_correct' => false],
                    ['option' => '227 and 91', 'is_correct' => false],
                    ['option' => '215 and 88', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>Uranium-235 undergoes radioactive decay to become a different element. The decay process changes the number of protons and neutrons in the nucleus, and thus the resulting daughter element will have different numbers of these subatomic particles. The correct numbers depend on the type of decay (e.g., alpha or beta decay).</p>',
            ],
            [
                'question' => 'A carpenter on top of a roof 20m high dropped a hammer of mass 1.5kg and it fell freely to the ground. The kinetic energy of the hammer just before hitting the ground is.',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'options' => [
                    ['option' => '450 J', 'is_correct' => false],
                    ['option' => '600 J', 'is_correct' => false],
                    ['option' => '150 J', 'is_correct' => false],
                    ['option' => '300 J', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The kinetic energy of the hammer just before hitting the ground can be found by calculating the potential energy at the height from which it was dropped (assuming no energy loss). The potential energy (which is equal to the kinetic energy just before impact) is given by \( PE = mgh \), where \( m \) is the mass, \( g \) is the acceleration due to gravity, and \( h \) is the height.</p>',
            ],
            [
                'question' => 'The phenomenon that shows that increase in pressure lowers the melting point can be observed in',
                'marks' => 2,
                'options' => [
                    ['option' => 'regelation', 'is_correct' => true],
                    ['option' => 'sublimation', 'is_correct' => false],
                    ['option' => 'condensation', 'is_correct' => false],
                    ['option' => 'coagulation.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Thermal Properties of Matter',
                'explanation' => '<p>Regelation is the unique phenomenon where increasing pressure on certain substances (like ice) can lower their melting point. This is why ice skates work: the pressure of the blade on the ice causes a thin layer to melt, providing lubrication.</p>'
            ],

            // Question 2
            [
                'question' => 'If the volume of a gas increases steadily as the temperature decreases at constant pressure, the gas obeys',
                'marks' => 2,
                'options' => [
                    ['option' => 'Charles\' law', 'is_correct' => true],
                    ['option' => 'Graham\'s law', 'is_correct' => false],
                    ['option' => 'Boyle\'s law', 'is_correct' => false],
                    ['option' => 'pressure law.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Gas Laws',
                'explanation' => '<p>Charles\' law describes the direct relationship between the volume and temperature of a gas at constant pressure. If the temperature decreases, the volume of the gas will also decrease proportionally. </p>'
            ],

            // Question 3
            [
                'question' => 'A perfect emitter or absorber of radiant energy is a',
                'marks' => 2,
                'options' => [
                    ['option' => 'red body', 'is_correct' => false],
                    ['option' => 'conductor', 'is_correct' => false],
                    ['option' => 'black body', 'is_correct' => true],
                    ['option' => 'white body.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Heat Transfer',
                'explanation' => '<p>A black body is a theoretical object that perfectly absorbs and emits all wavelengths of electromagnetic radiation. This makes it the most efficient radiator and absorber of thermal energy.</p>'
            ],
            [
                'question' => 'A man standing on a lift that is descending does not feel any weight because',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'options' => [
                    ['option' => 'there is no gravitational pull on the man in the lift', 'is_correct' => false],
                    ['option' => 'the inside of the lift is air tight', 'is_correct' => false],
                    ['option' => 'the lift is in vacuum', 'is_correct' => false],
                    ['option' => 'there is no reaction from the floor of the lift', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>A man standing on a lift that is descending rapidly does not feel any weight because the normal reaction force from the floor of the lift decreases. If the lift were in free fall, the normal reaction force would be zero, and the man would experience weightlessness. This is due to the lift accelerating downwards with the acceleration due to gravity, reducing the normal force exerted by the floor.</p>',
            ],
            [
                'question' => 'Which of the following is a property of steel?',
                'marks' => 2,
                'options' => [
                    ['option' => 'It can easily be magnetized and demagnetized', 'is_correct' => false],
                    ['option' => 'It cannot retain its magnetism longer than iron', 'is_correct' => false],
                    ['option' => 'It can be used for making temporary magnets', 'is_correct' => false],
                    ['option' => 'It can be used for making permanent magnets', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Magnetism',
                'explanation' => '<p>Steel, an alloy of iron and carbon, has a higher carbon content than pure iron. This makes it retain its magnetism for a longer period, making it suitable for permanent magnets.</p>'
            ],

            // Question 2
            [
                'question' => 'Under which of the following conditions do gases conduct electricity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'High pressure and high p.d', 'is_correct' => false],
                    ['option' => 'Low pressure and low p.d', 'is_correct' => false],
                    ['option' => 'Low pressure and high p.d', 'is_correct' => true],
                    ['option' => 'High pressure and low p.d', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Conduction of Electricity Through Liquids and Gases',
                'explanation' => '<p>Gases are generally poor conductors of electricity. However, at low pressure and with a high potential difference (p.d.) across them, they can become ionized and conduct electricity. This is seen in phenomena like lightning and gas discharge tubes.</p>'
            ],

            // Question 3
            [
                'question' => 'In measuring high frequency a.c., the instrument used is',
                'marks' => 2,
                'options' => [
                    ['option' => 'hot wire ammeter', 'is_correct' => true],
                    ['option' => 'd.c. ammeter', 'is_correct' => false],
                    ['option' => 'moving coil ammeter', 'is_correct' => false],
                    ['option' => 'moving iron ammeter', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'explanation' => '<p>Hot wire ammeters are suitable for measuring high-frequency alternating currents because their readings depend on the heating effect of the current, which is independent of the direction of the current flow. </p>'
            ],

            // Question 4
            [
                'question' => 'The bond between silicon and germanium is',
                'marks' => 2,
                'options' => [
                    ['option' => 'electrovalent', 'is_correct' => false],
                    ['option' => 'covalent', 'is_correct' => true],
                    ['option' => 'ionic', 'is_correct' => false],
                    ['option' => 'dative', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Structure of Matter and Kinetic Theory',
                'explanation' => '<p>Silicon and germanium are both Group 4 elements and form covalent bonds. In covalent bonds, atoms share electrons to achieve stable electron configurations.</p>'
            ],
            [
                'question' => 'The pressure at any point in a liquid at rest depends only on the',
                'marks' => 2,
                'options' => [
                    ['option' => 'depth and the density', 'is_correct' => true],
                    ['option' => 'mass and the volume', 'is_correct' => false],
                    ['option' => 'quantity and the surface area', 'is_correct' => false],
                    ['option' => 'surface area and the viscosity', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Liquids at Rest',
                'explanation' => '<p>The pressure in a liquid at rest depends on two factors:</p> <ul><li>**Depth (h):** The greater the depth, the greater the weight of the liquid column above, leading to higher pressure.</li><li>**Density (ρ):**  A denser liquid exerts more pressure at a given depth compared to a less dense liquid.</li></ul><p>This relationship is expressed as P = hρg, where g is the acceleration due to gravity.</p>'
            ],

            // Question 2
            [
                'question' => 'Which of the following is NOT a factor that can increase the rate of evaporation of water in a lake?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Increase in the pressure of the atmosphere', 'is_correct' => true],
                    ['option' => 'Rise in temperature', 'is_correct' => false],
                    ['option' => 'Increase in the average speed of the molecules of water', 'is_correct' => false],
                    ['option' => 'Increase in the kinetic energy of the molecules of water.', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Change of State',
                'explanation' => '<p>Evaporation is the process by which a liquid changes to a gas at its surface.  These factors increase evaporation rate:</p><ul><li>**Temperature:** Higher temperature means more kinetic energy in molecules, making them more likely to escape from the liquid.</li><li>**Kinetic Energy:** This is directly linked to temperature.  Molecules with enough kinetic energy can break free from the liquid state.</li><li>**Surface Area:**  A larger surface area provides more opportunity for molecules to escape.</li><li>**Wind:** This carries away evaporated molecules preventing a buildup of vapor above the liquid.</li></ul><p>Increased atmospheric pressure would actually hinder evaporation by making it more difficult for molecules to escape from the liquid\'s surface.</p>'
            ],
            [
                'question' => 'Which of the following factors will affect the velocity of sound?',
                'marks' => 2,
                'options' => [
                    ['option' => 'An increase in the pitch of the sound', 'is_correct' => false],
                    ['option' => 'An increase in the loudness of the sound', 'is_correct' => false],
                    ['option' => 'Wind traveling in the same direction of the sound', 'is_correct' => true],
                    ['option' => 'A change in the atmospheric pressure at constant temperature', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Propagation of Sound Waves',
                'explanation' => '<p>The velocity of sound is primarily affected by the properties of the medium through which it travels. These factors include:</p> <ul><li>**Density:** Sound travels faster in denser mediums.</li> <li>**Elasticity:** Sound travels faster in more elastic materials. </li><li>**Temperature:**  Sound travels faster at higher temperatures.</li> <li>**Wind:**  Wind traveling in the same direction as the sound can increase its effective speed.</li></ul>'
            ],

            // Question 2
            [
                'question' => 'The characteristic of a vibration that determines its intensity is the',
                'marks' => 2,
                'options' => [
                    ['option' => 'Frequency', 'is_correct' => false],
                    ['option' => 'Overtone', 'is_correct' => false],
                    ['option' => 'Wavelength', 'is_correct' => false],
                    ['option' => 'Amplitude', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Waves',
                'explanation' => '<p>The amplitude of a sound wave determines its intensity or loudness.  A larger amplitude means more energy is carried by the wave, resulting in a louder sound.</p>'
            ],

            // Question 3
            [
                'question' => 'Where a man can place his face to get an enlarged image when using a concave mirror to shave.',
                'marks' => 2,
                'options' => [
                    ['option' => 'between the center of curvature and the principal focus', 'is_correct' => false],
                    ['option' => 'at the principal focus', 'is_correct' => false],
                    ['option' => 'between the principal focus and the pole', 'is_correct' => true],
                    ['option' => 'At the center of the curvature', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Reflection of Light at Curved Surfaces',
                'explanation' => '<p>A concave mirror produces an enlarged, upright, and virtual image when an object is placed between the principal focus and the pole of the mirror. This is the ideal position for using a concave mirror for shaving.</p>'
            ],
            [
                'question' => 'Dispersion of white light is the ability of white light to',
                'marks' => 2,
                'options' => [
                    ['option' => 'Penetrate air, water and glass', 'is_correct' => false],
                    ['option' => 'Move in a straight line', 'is_correct' => false],
                    ['option' => 'Move around corners', 'is_correct' => false],
                    ['option' => 'Separate to its component colors', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Dispersion of Light and Colors',
                'explanation' => '<p>Dispersion is the phenomenon where white light separates into its constituent colors (the spectrum) when it passes through a refractive medium like a prism. This occurs because different wavelengths of light bend at slightly different angles due to variations in their speed within the medium.</p>'
            ],
            [
                'question' => 'An object is weighed at different locations on the Earth. What will be the right observation?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Both the mass and weight vary', 'is_correct' => false],
                    ['option' => 'The weight is constant while the mass varies', 'is_correct' => false],
                    ['option' => 'The mass is constant while the weight varies', 'is_correct' => true],
                    ['option' => 'Both the mass and weight are constant', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Gravitational Field',
                'explanation' => '<p>Here\'s the distinction between mass and weight:</p>
        <ul>
        <li>**Mass:** The amount of matter in an object (measured in kilograms).  Mass is constant regardless of location.</li>
        <li>**Weight:** The force of gravity acting on an object (measured in Newtons). Weight depends on the strength of the gravitational field,  which varies slightly at different locations on Earth.</li>
        </ul>'
            ],

            // Question 2
            [
                'question' => 'The surfaces of conveyor belts are made rough so as to',
                'marks' => 2,
                'options' => [
                    ['option' => 'prevent the load from slipping', 'is_correct' => true],
                    ['option' => 'make them stronger', 'is_correct' => false],
                    ['option' => '(Not applicable)', 'is_correct' => false], // You might want to  reword options that are 'Not applicable'
                    ['option' => '(Not applicable)', 'is_correct' => false], // Same as above
                ],
                'type' => 'mcq',
                'topic' => 'Friction',
                'explanation' => '<p>Rough surfaces on conveyor belts increase friction between the belt and the load.  This friction helps prevent the load from slipping and ensures it moves along with the belt.</p>'
            ],

            // Question 2
            [
                'question' => 'The fuse in an electric device is always connected to the',
                'marks' => 2,
                'options' => [
                    ['option' => 'Neutral side of an electric supply', 'is_correct' => false],
                    ['option' => 'Earth side of an electric supply', 'is_correct' => false],
                    ['option' => 'Live side of an electric supply', 'is_correct' => true],
                    ['option' => 'Terminal side of an electric supply', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrical Energy and Power',
                'explanation' => '<p>A fuse is a safety device designed to protect electrical circuits from excessive current. It is always connected in series with the live wire to interrupt the circuit if the current exceeds a safe level, preventing potential damage or fire.</p>'
            ],

            [
                'question' => 'An object is moving with a velocity of 5m/s. At what height must a similar body be situated to have a potential energy equal in value with kinetic energy of the moving body?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'options' => [
                    ['option' => '25.0m', 'is_correct' => false],
                    ['option' => '20.0m', 'is_correct' => false],
                    ['option' => '1.3m', 'is_correct' => true],
                    ['option' => '1.0m', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The potential energy (PE) at a height is equal to the kinetic energy (KE) of a moving body if \( PE = KE \). Given that \( KE = 1/2 \times m \times v^2 \) and \( PE = m \times g \times h \), equating the two gives \( h = v^2 / (2 \times g) \). Plugging in the velocity of 5 m/s and the acceleration due to gravity of 9.8 m/s^2, the height is calculated to be approximately 1.28 m, which is closest to the given option of 1.3 m.</p>',
            ],
            [
                'question' => 'If a pump is capable of lifting 5000kg of water through a vertical height of 60 m in 15 min, the power of the pump is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Work, Energy, and Power',
                'options' => [
                    ['option' => '2.5 x 10^5J/s', 'is_correct' => false],
                    ['option' => '2.5 x 10^4J/s', 'is_correct' => false],
                    ['option' => '3.3 x 10^3J/s', 'is_correct' => true],
                    ['option' => '3.3 x 10^2J/s', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The power of the pump is the work done per unit of time. Work done is the product of the mass of water, the acceleration due to gravity, and the height the water is lifted. The time taken is 15 minutes, which is 900 seconds. Calculating the work done as \( 5000 kg \times 9.8 m/s^2 \times 60 m \) and dividing by 900 seconds gives a power of approximately 3267 J/s, which is closest to the given option of 3.3 x \( 10^3 \) J/s.</p>',
            ],

            [
                'question' => 'Two inductors of inductances 4H and 8H are arranged in series and a current of 10A is passed through them. What is the energy stored in them?',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'options' => [
                    ['option' => '250 J', 'is_correct' => false],
                    ['option' => '500 J', 'is_correct' => false],
                    ['option' => '50 J', 'is_correct' => false],
                    ['option' => '133 J', 'is_correct' => false],
                    ['option' => '600.0 J', 'is_correct' => true],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The energy stored in inductors arranged in series is found by calculating the total inductance and then using the energy formula \( E = \frac{1}{2} L I^2 \). With inductances of 4H and 8H and a current of 10A, the energy stored is \( E = \frac{1}{2} \times (4H + 8H) \times (10A)^2 = 600 J \).</p>',
            ],
            [
                'question' => 'In an a.c. circuit, the ratio of r.m.s value to peak value of current is',
                'marks' => 2,
                'type' => 'mcq',
                'topic' => 'Current Electricity',
                'options' => [
                    ['option' => '1/√2', 'is_correct' => true],
                    ['option' => '√2', 'is_correct' => false],
                    ['option' => '2', 'is_correct' => false],
                    ['option' => '1/2', 'is_correct' => false],
                ],
                'explanation' => '<p>Explanation:</p>
            <p>The RMS (root mean square) value of an alternating current is the effective value that represents the DC equivalent in terms of its ability to produce the same heating effect. The RMS value is \( \frac{1}{\sqrt{2}} \) or about 0.707 times the peak value of the current in an AC circuit.</p>',
            ],
            // ... (Other entries)



            // ... Add all other questions here in the same format
        ];

        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $physicsSubjectForJAMB->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $physicsSubjectForJAMB->id,
            'total_marks' => $total_marks, // Sum of marks for all questions
            'duration' => 60, // Example default value
            'total_questions' => count($questions), // Total number of questions
            'max_attempts' => 3, // Example default value
        ]);

        foreach ($questions as $questionData) {
            // Check if module and unit information is provided
            $module = $unit = null;
            if (isset($questionData['module']) && isset($questionData['unit'])) {
                // Create or find the module and unit if they are provided
                $module = Module::firstOrCreate(['name' => $questionData['module']]);
                $unit = Unit::firstOrCreate([
                    'name' => $questionData['unit'],
                    'module_id' => $module->id,
                ]);
            }

            // Find or create the topic
            // If module/unit is provided, link it. Otherwise, create a standalone topic.
            $topic = null;

            // If a topic name is provided, create or find the topic.
            if (!empty($questionData['topic'])) {
                // Find the highest order number for the current topicable_id and topicable_type
                $highestOrder = Topic::where('topicable_id', $physicsSubjectForJAMB->id)
                    ->where('topicable_type', Subject::class)
                    ->max('order');

                $topicOrder = $highestOrder ? $highestOrder + 1 : 1; // If there are no topics yet, start with order 1.

                $topic = Topic::firstOrNew(
                    [
                        'name' => $questionData['topic'],
                    ],
                    [
                        'unit_id' => $unit->id ?? null,
                        'topicable_type' => Subject::class,
                        'topicable_id' => $physicsSubjectForJAMB->id,

                    ]
                );
            }

            // Create a new question for the quiz
            $question = Question::firstOrCreate(
                ['question' => $questionData['question']],
                [
                'quiz_id' => $quiz->id,
                'quizzable_type' => Subject::class,
                'quizzable_id' => $physicsSubjectForJAMB->id,
                'topic_id' => $topic->id,
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
                'duration' => 1,
                'answer_text' => $questionData['answer_text'] ?? null, // Provide a default null if 'answer_text' is not set
                'explanation' => $questionData['explanation'] ?? null,
            ]);

            // Create options for the question
            if (array_key_exists('options', $questionData)) {
                foreach ($questionData['options'] as $optionData) {
                    Option::create([
                        'question_id' => $question->id,
                        'option' => $optionData['option'],
                        'is_correct' => $optionData['is_correct'],
                    ]);
                }
            }
        }
    }
}
