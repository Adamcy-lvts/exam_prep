<?php

namespace Database\Seeders;

use App\Models\Topic;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TopicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, retrieve the Physics subject
        $physics = Subject::where('name', 'Physics')->first();

        $topics = [
            'Measurements and Units',
            'Scalars and Vectors',
            'Motion',
            'Gravitational Field',
            'Equilibrium of Forces',
            'Work, Energy, and Power',
            'Friction',
            'Simple Machines',
            'Elasticity',
            'Pressure',
            'Liquids at Rest',
            'Temperature and Its Measurement',
            'Thermal Expansion',
            'Gas Laws',
            'Quantity of Heat',
            'Change of State',
            'Vapours',
            'Structure of Matter and Kinetic Theory',
            'Heat Transfer',
            'Waves',
            'Propagation of Sound Waves',
            'Characteristics of Sound Waves',
            'Light Energy',
            'Reflection of Light at Plane and Curved Surfaces',
            'Refraction of Light Through Plane and Curved Surfaces',
            'Optical Instruments',
            'Dispersion of Light and Colours',
            'Electrostatics',
            'Capacitors',
            'Electric Cells',
            'Current Electricity',
            'Electrical Energy and Power',
            'Magnets and Magnetic Fields',
            'Force on a Current-Carrying Conductor in a Magnetic Field',
            'Electromagnetic Induction',
            'Simple A.C. Circuits',
            'Conduction of Electricity Through Liquids and Gases',
            'Elementary Modern Physics',
            'Introductory Electronics'
        ];

        foreach ($topics as $key => $name) {
            $topic = new Topic([
                'name' => $name,
                'topicable_type' => Subject::class,
                'topicable_id' => $physics->id,
                'order' => $key + 1, // Assuming you want to order them by their appearance in the array
            ]);

            // Assuming you have set up the relationship in the Subject model to accept topics
            $physics->topics()->save($topic);
        }

        $chemistryId = Subject::where('name', 'Chemistry')->first()->id;

        $topics = [
            'Separation of mixtures and purification of chemical substances',
            'Chemical combination',
            'Kinetic theory of matter and Gas Laws',
            'Atomic structure and bonding',
            'Air',
            'Water',
            'Solubility',
            'Environmental Pollution',
            'Acids, bases, and salts',
            'Oxidation and reduction',
            'Electrolysis',
            'Energy changes',
            'Rates of Chemical Reactions',
            'Chemical equilibrium',
            'Non-metals and their compounds',
            'Metals and their compounds',
            'Organic Compounds',
            'Chemistry and Industry',
        ];

        foreach ($topics as $key => $topicName) {
            Topic::create([
                'name' => $topicName,
                'topicable_type' => Subject::class,
                'topicable_id' => $chemistryId,
                'order' => $key + 1,
            ]);
        }

        $biology = Subject::where('name', 'Biology')->first();

        $topics = [
            'Living Organisms',
            'Evolution',
            'Transport',
            'Respiration',
            'Excretion',
            'Support and movement',
            'Reproduction',
            'Growth',
            'Factors affecting the distribution of Organisms',
            'Symbiotic interactions of plants and animals',
            'Natural Habitats',
            'Local (Nigerian) Biomes',
            'The Ecology of Population',
            'Soil',
            'Humans and Environment',
            'Heredity AND Variations'

        ];

        foreach ($topics as $key => $topicName) {
            Topic::create([
                'name' => $topicName,
                'topicable_type' => Subject::class,
                'topicable_id' => $biology->id, // Assuming your Topic model has a 'subject_id' column
                'order' => $key + 1,
            ]);
        }

        $mathSubjectId = Subject::where('name', 'Mathematics')->first()->id;

        $topics = [
            'Number bases',
            'Fractions, Decimals, Approximations, and Percentages',
            'Indices, Logarithms, and Surds',
            'Sets',
            'Polynomials',
            'Variation',
            'Inequalities',
            'Progression',
            'Binary Operations',
            'Matrices and Determinants',
            'Euclidean Geometry',
            'Mensuration',
            'Loci',
            'Coordinate Geometry',
            'Trigonometry',
            'Differentiation',
            'Application of Differentiation',
            'Integration',
            'Representation of Data',
            'Measures of Location',
            'Measures of Dispersion',
            'Permutation and Combination',
            'Probability',
        ];

        foreach ($topics as $key => $topicName) {
            Topic::create([
                'name' => $topicName,
                'topicable_type' => Subject::class,
                'topicable_id' => $mathSubjectId, // Assuming your Topic model has a 'subject_id' column
                'order' => $key + 1,
            ]);
        }

        $useOfEnglishId = Subject::where('name', 'Use of English')->first()->id;

        $topics = [
            'Description',
            'Narration',
            'Exposition',
            'Argumentation/Persuasion',
            'Synonyms',
            'Antonyms',
            'Homonyms',
            'Clause and Sentence Patterns',
            'Word Classes and Their Functions',
            'Mood, Tense,Aspect, Number Agreement/Concord, degree (positive,comparative and superlative) and question tags',
            'Degrees of Comparison',
            'Question Tags',
            'Punctuation',
            'Spelling',
            'Vowels (Monophthongs and Diphthongs)',
            'Consonants (Including Clusters)',
            'Rhymes (Including Homophones)',
            'Word Stress (Monosyllabic and Polysyllabic)',
            'Intonation Patterns',
        ];

        foreach ($topics as $key => $topicName) {
            Topic::create([
                'name' => $topicName,
                'topicable_type' => Subject::class,
                'topicable_id' => $useOfEnglishId,
                'order' => $key + 1,
            ]);
        }
    }
}
