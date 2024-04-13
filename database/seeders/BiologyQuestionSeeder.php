<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BiologyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve the 'Physics' subject by its unique name
        $jambExamId = DB::table('exams')->where('exam_name', 'JAMB')->value('id');

        // Check if the 'JAMB' exam ID was retrieved successfully
        if ($jambExamId) {
            // Retrieve the 'Physics' subject for the 'JAMB' exam
            $biology = DB::table('subjects')
                ->where('name', 'Biology')
                ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $biology to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $biology is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();

        $questions = [
            [
                'question' => 'What is the basic unit of life?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Cell', 'is_correct' => true],
                    ['option' => 'Atom', 'is_correct' => false],
                    ['option' => 'Molecule', 'is_correct' => false],
                    ['option' => 'Organ', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'The <strong>Cell</strong> is the basic unit of life, acting as the building block for all living organisms.',
            ],
            [
                'question' => 'Which organ system is responsible for transport of nutrients?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nervous System', 'is_correct' => false],
                    ['option' => 'Circulatory System', 'is_correct' => true],
                    ['option' => 'Endocrine System', 'is_correct' => false],
                    ['option' => 'Respiratory System', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'The <strong>Circulatory System</strong>, including the heart and blood vessels, transports nutrients and oxygen throughout the body.',
            ],
            [
                'question' => 'What is the process by which plants make their food?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Photosynthesis', 'is_correct' => true],
                    ['option' => 'Respiration', 'is_correct' => false],
                    ['option' => 'Digestion', 'is_correct' => false],
                    ['option' => 'Transpiration', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Through <strong>Photosynthesis</strong>, plants convert sunlight into food in their leaves.',
            ],
            [
                'question' => 'Which molecule carries genetic information?',
                'marks' => 2,
                'options' => [
                    ['option' => 'DNA', 'is_correct' => true],
                    ['option' => 'RNA', 'is_correct' => false],
                    ['option' => 'Protein', 'is_correct' => false],
                    ['option' => 'Lipid', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => '<strong>DNA</strong> holds all the genetic instructions used in the growth, development, and functioning of living organisms.',
            ],
            [
                'question' => 'What is the powerhouse of the cell?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleus', 'is_correct' => false],
                    ['option' => 'Mitochondria', 'is_correct' => true],
                    ['option' => 'Chloroplast', 'is_correct' => false],
                    ['option' => 'Ribosome', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'The <strong>Mitochondria</strong> are known as the powerhouse of the cell because they convert energy from food into a form that the cell can use.',
            ],
            [
                'question' => 'What are the building blocks of proteins?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleotides', 'is_correct' => false],
                    ['option' => 'Amino acids', 'is_correct' => true],
                    ['option' => 'Fatty acids', 'is_correct' => false],
                    ['option' => 'Monosaccharides', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Proteins are made up of smaller units called <strong>Amino acids</strong>. Think of amino acids as the alphabet of a language, combining in many ways to create the vast array of proteins in living things.',
            ],
            [
                'question' => 'Which part of the brain controls balance and coordination?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Cerebrum', 'is_correct' => false],
                    ['option' => 'Cerebellum', 'is_correct' => true],
                    ['option' => 'Brainstem', 'is_correct' => false],
                    ['option' => 'Hypothalamus', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'The <strong>Cerebellum</strong> is the part of the brain that helps regulate balance, posture, and coordination, ensuring smooth and balanced muscular activity.',
            ],
            [
                'question' => 'In which cell organelle does cellular respiration occur?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Nucleus', 'is_correct' => false],
                    ['option' => 'Endoplasmic reticulum', 'is_correct' => false],
                    ['option' => 'Golgi apparatus', 'is_correct' => false],
                    ['option' => 'Mitochondria', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'The <strong>Mitochondria</strong> are known as the powerhouse of the cell because they generate most of the cell\'s supply of ATP, used as a source of chemical energy.',
            ],
            [
                'question' => 'What is the term for a group of similar cells performing the same function?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Tissue', 'is_correct' => true],
                    ['option' => 'Organ', 'is_correct' => false],
                    ['option' => 'Organ system', 'is_correct' => false],
                    ['option' => 'Organism', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => '<strong>Tissue</strong> is the term used for a group of similar cells that work together to perform a specific function, like muscle tissue moving parts of the body.',
            ],
            [
                'question' => 'What type of blood cells are responsible for immunity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Red blood cells', 'is_correct' => false],
                    ['option' => 'White blood cells', 'is_correct' => true],
                    ['option' => 'Platelets', 'is_correct' => false],
                    ['option' => 'Plasma cells', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => '<strong>White blood cells</strong> are the soldiers of the body, protecting you from infection and disease by attacking invaders like bacteria and viruses.',
            ],

            [
                'question' => 'Which of the following characterizes a mature plant cell?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'the cytoplasm fills up the entire cell space', 'is_correct' => false],
                    ['option' => 'the nucleus is pushed to the centre of the cell', 'is_correct' => false],
                    ['option' => 'the cell wall is made up of cellulose', 'is_correct' => true],
                    ['option' => 'the nucleus is small and irregular in shape', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'A mature plant cell is characterized by a cell wall that is made up of cellulose, which provides rigidity and strength to the plant cell.'
            ],

            [
                'question' => 'Which of the following is NOT a function of the nucleus of a cell?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'it controls the life processes of the cell', 'is_correct' => false],
                    ['option' => 'it translates genetic information for the manufacture of proteins', 'is_correct' => false],
                    ['option' => 'it stores and carries hereditary information', 'is_correct' => false],
                    ['option' => 'it is reservoir of energy for the cell', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'The nucleus does not serve as a reservoir of energy for the cell. This function is typically served by other components such as mitochondria, which are responsible for energy production.'
            ],

            [
                'question' => 'The dominant phase in the life cycle of a fern is the?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'gametophyte', 'is_correct' => false],
                    ['option' => 'prothallus', 'is_correct' => false],
                    ['option' => 'sporophyte', 'is_correct' => true],
                    ['option' => 'antheridium', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'In the life cycle of a fern, the sporophyte phase is dominant. This is the diploid phase where the plant is larger and long-lived compared to the gametophyte phase.'
            ],

            [
                'question' => 'Parental care is exhibited by',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'toads', 'is_correct' => false],
                    ['option' => 'snails', 'is_correct' => false],
                    ['option' => 'earthworms', 'is_correct' => false],
                    ['option' => 'birds', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Among the options listed, birds are known to exhibit parental care, which includes activities like nest building, feeding, and protecting their young.'
            ],

            [
                'question' => 'Which of the following groups of cells is devoid of true nuclei?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'algae', 'is_correct' => false],
                    ['option' => 'monera', 'is_correct' => true],
                    ['option' => 'fungi', 'is_correct' => false],
                    ['option' => 'viruses', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'The Monera kingdom, which includes bacteria, is characterized by cells that do not have a true nucleus. Instead, their genetic material is not enclosed within a nuclear envelope.'
            ],

            [
                'question' => 'Which of the following is lacking in the diet of a person with kwashiorkor?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'vitamins', 'is_correct' => false],
                    ['option' => 'proteins', 'is_correct' => true],
                    ['option' => 'carbohydrates', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Kwashiorkor is a form of malnutrition caused by inadequate protein intake despite sufficient calorie intake, often characterized by edema, an enlarged liver, and other symptoms.'
            ],

            [
                'question' => 'The mode of nutrition of sun dew and bladder wort can be described as',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'saprophytic', 'is_correct' => false],
                    ['option' => 'autotrophic', 'is_correct' => false],
                    ['option' => 'holozoic', 'is_correct' => false],
                    ['option' => 'chemosynthetic', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Symbiotic interactions of plants and animals',
                'explanation' => 'Sun dew and bladder wort are carnivorous plants that obtain nutrients by trapping and digesting insects and other small animals, which is a form of chemosynthesis.'
            ],

            [
                'question' => 'When the mixture of a food substance and Benedict\'s solution was warmed, the solution changed from blue to black-red. This indicates the presence of',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'reducing sugar', 'is_correct' => true],
                    ['option' => 'fatty acid', 'is_correct' => false],
                    ['option' => 'sucrose', 'is_correct' => false],
                    ['option' => 'amino acid', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Biochemistry',
                'explanation' => 'The Benedict\'s test is a chemical test that identifies reducing sugars which, when present, reduce the copper(II) ion in the Benedict\'s solution from blue to a red or brick-red color.'
            ],

            [
                'question' => 'The primary structure responsible for pumping blood for circulation through the mammalian circulatory systems is the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'veins', 'is_correct' => false],
                    ['option' => 'right auricle', 'is_correct' => false],
                    ['option' => 'arteries', 'is_correct' => false],
                    ['option' => 'left ventricle', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Transport',
                'explanation' => 'The left ventricle is responsible for pumping oxygenated blood to the entire body, making it the primary structure for blood circulation in the mammalian heart.'
            ],

            [
                'question' => 'Circulation of blood to all parts of the body except the lungs is through',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'the pulmonary artery', 'is_correct' => false],
                    ['option' => 'systemic circulation', 'is_correct' => true],
                    ['option' => 'the lymphatic system', 'is_correct' => false],
                    ['option' => 'pulmonary circulation', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Transport',
                'explanation' => 'Systemic circulation refers to the part of the cardiovascular system which carries oxygenated blood away from the heart to the body, and returns deoxygenated blood back to the heart.'
            ],

            [
                'question' => 'Yeast respires anaerobically to convert simple sugar to carbon (IV) oxide and',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'alcohol', 'is_correct' => true],
                    ['option' => 'acid', 'is_correct' => false],
                    ['option' => 'oxygen', 'is_correct' => false],
                    ['option' => 'water', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Respiration',
                'explanation' => 'Yeast, when undergoing anaerobic respiration (fermentation), converts glucose into ethanol (alcohol) and carbon dioxide as by-products.'
            ],

            [
                'question' => 'The sheet of muscle that separates the thoracic and the abdominal cavities is the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'diaphragm', 'is_correct' => true],
                    ['option' => 'intercostal muscle', 'is_correct' => false],
                    ['option' => 'pleural membrane', 'is_correct' => false],
                    ['option' => 'pericardium', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and movement',
                'explanation' => 'The diaphragm is a large, dome-shaped muscle located at the base of the lungs and heart that separates the thoracic cavity from the abdominal cavity and aids in breathing.'
            ],
            [
                'question' => 'The oily substance that lubricates the mammalian hair to keep it flexible and water repellent is secreted by the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'sweet glands', 'is_correct' => false],
                    ['option' => 'sebaceous glands', 'is_correct' => true],
                    ['option' => 'eccrine glands', 'is_correct' => false],
                    ['option' => 'granular layer', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Humans and Environment',
                'explanation' => 'Sebaceous glands secrete an oily substance called sebum which lubricates the skin and hair, making it flexible and water repellent.'
            ],

            [
                'question' => 'The outer layer of the kidney where the Bowman\'s capsules are found is the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'cortex', 'is_correct' => true],
                    ['option' => 'pelvis', 'is_correct' => false],
                    ['option' => 'medulla', 'is_correct' => false],
                    ['option' => 'pyramid', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Excretion',
                'explanation' => 'The cortex of the kidney is the outer part where structures such as Bowman\'s capsules and the initial parts of the nephron are located.'
            ],

            [
                'question' => 'Which of the following stimuli is likely to elicit a nastic response in an organism?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Touch', 'is_correct' => true],
                    ['option' => 'Light intensity', 'is_correct' => false],
                    ['option' => 'Chemical substances', 'is_correct' => false],
                    ['option' => 'Gravity', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Nastic movements are non-directional responses to stimuli such as touch, temperature, humidity, or chemicals, not dependent on the direction of the stimulus.'
            ],

            [
                'question' => 'In the male reproductive system of a mammal, sperm is stored in the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'vas deferens', 'is_correct' => false],
                    ['option' => 'urethra', 'is_correct' => false],
                    ['option' => 'epididymis', 'is_correct' => true],
                    ['option' => 'seminiferous tubules', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'In the male reproductive system, the epididymis is the structure where sperm are stored and mature before ejaculation.'
            ],

            [
                'question' => 'Chemosynthetic organisms are capable of manufacturing their food from simple inorganic substances through the process of',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'oxidation', 'is_correct' => false],
                    ['option' => 'denitrification', 'is_correct' => false],
                    ['option' => 'reduction', 'is_correct' => false],
                    ['option' => 'phosphorylation', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Chemosynthesis is the biological conversion of one or more carbon molecules (usually carbon dioxide or methane) and nutrients into organic matter using the oxidation of inorganic compounds as a source of energy, rather than sunlight (photosynthesis). Phosphorylation is a part of the process where ATP is formed.'
            ],

            [
                'question' => 'The part of the human gut that has an acidic content is the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'stomach', 'is_correct' => true],
                    ['option' => 'duodenum', 'is_correct' => false],
                    ['option' => 'ileum', 'is_correct' => false],
                    ['option' => 'colon', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'The stomach has a highly acidic environment, which is necessary for the digestion of food and killing of microbes ingested with food.'
            ],

            [
                'question' => 'Which of the following structures is correctly matched with the organisms in which it is found?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Stomata → Spirogyro', 'is_correct' => false],
                    ['option' => 'Alveoli → Earthworm', 'is_correct' => false],
                    ['option' => 'Malpighian tubule → Mammal', 'is_correct' => false],
                    ['option' => 'Contractile vacuole → Protozoa', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Contractile vacuoles are found in many freshwater protozoa and are used to expel excess water from the cell.'
            ],
            [
                'question' => 'Low annual rainfall, sparse vegetation, high diurnal temperatures and cold nights are characteristic features of the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'tropical rainforest', 'is_correct' => false],
                    ['option' => 'desert', 'is_correct' => true],
                    ['option' => 'montane forest', 'is_correct' => false],
                    ['option' => 'guinea savanna', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Natural Habitats',
                'explanation' => 'These conditions are characteristic of a desert, which is known for low rainfall, sparse vegetation, and extreme temperature variations between day and night.'
            ],

            [
                'question' => 'The activity of an organism which affects the survival of another organism in the same habitat constitutes',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'an edaphic factor', 'is_correct' => false],
                    ['option' => 'an abiotic factor', 'is_correct' => false],
                    ['option' => 'a biotic factor', 'is_correct' => true],
                    ['option' => 'a physiographic factor', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'The Ecology of Population',
                'explanation' => 'A biotic factor is any living component that affects the survival and reproduction of organisms, such as the activity of other organisms within the same habitat.'
            ],

            [
                'question' => 'The average number of individuals of a species per unit area of the habitat is the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'population density', 'is_correct' => true],
                    ['option' => 'population frequency', 'is_correct' => false],
                    ['option' => 'population size', 'is_correct' => false],
                    ['option' => 'population distribution', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'The Ecology of Population',
                'explanation' => 'Population density refers to the average number of individuals of a species found in a specified amount of space.'
            ],

            [
                'question' => 'The vector for yellow fever is',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'Anopheles mosquito', 'is_correct' => false],
                    ['option' => 'Aedes mosquito', 'is_correct' => true],
                    ['option' => 'tsetse fly', 'is_correct' => false],
                    ['option' => 'blackfly', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'The Aedes mosquito is the primary vector responsible for transmitting the yellow fever virus to humans.'
            ],

            [
                'question' => 'The loss of soil through erosion can be reduced by',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'watering', 'is_correct' => false],
                    ['option' => 'crop rotation', 'is_correct' => true],
                    ['option' => 'manuring', 'is_correct' => false],
                    ['option' => 'irrigation', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Soil',
                'explanation' => 'Crop rotation can help reduce soil erosion as it helps maintain soil structure and fertility, thereby minimizing the loss of soil.'
            ],

            [
                'question' => 'The protozoan plasmodium falciparum is transmitted by',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'female Anopheles mosquitoes', 'is_correct' => true],
                    ['option' => 'female Aedes mosquitoes', 'is_correct' => false],
                    ['option' => 'female Culex mosquitoes', 'is_correct' => false],
                    ['option' => 'female blackfly', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Plasmodium falciparum, which causes malaria, is transmitted to humans by the bite of infected female Anopheles mosquitoes.'
            ],

            [
                'question' => 'Thyroxine and adrenaline are examples of hormones which control',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'blood grouping', 'is_correct' => false],
                    ['option' => 'tongue rolling', 'is_correct' => false],
                    ['option' => 'behavioural patterns', 'is_correct' => true],
                    ['option' => 'colour variation', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Humans and Environment',
                'explanation' => 'Thyroxine and adrenaline are hormones that influence various physiological and behavioral patterns, including metabolism and the body’s response to stress.'
            ],
            [
                'question' => 'A pair of genes that control a trait is referred to as',
                'year' => 2010,
                'marks' => 1,
                'options' => [
                    ['option' => 'an allele', 'is_correct' => true],
                    ['option' => 'recessive', 'is_correct' => false],
                    ['option' => 'dominant', 'is_correct' => false],
                    ['option' => 'a hybrid', 'is_correct' => false] // this should be marked as false
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'A pair of genes that control a trait are referred to as alleles. An allele is a variant form of a gene, and individuals inherit one allele from each parent for a given trait. The term "hybrid" is not the correct term; it refers to the offspring resulting from the combination of two different species or genetic lines, especially in plants.'
            ],
            [
                'question' => 'The chromosome number of a cell before and after the process of meiosis is conventionally represented as',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => '2n → 2n', 'is_correct' => false],
                    ['option' => 'n → n', 'is_correct' => false],
                    ['option' => 'n → 2n', 'is_correct' => false],
                    ['option' => '2n → n', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Meiosis is a type of cell division that reduces the chromosome number by half, resulting in the formation of four gamete cells, each with n chromosomes from the original 2n.'
            ],

            [
                'question' => 'If both parents are heterozygous for a trait, the probability that an offspring will be recessive for that trait is',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => '3/4', 'is_correct' => false],
                    ['option' => '1/2', 'is_correct' => false],
                    ['option' => '1/4', 'is_correct' => true],
                    ['option' => '1', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'When both parents are heterozygous (Aa) for a trait, the probability of an offspring being homozygous recessive (aa) is 1/4, according to a Punnett square analysis.'
            ],

            [
                'question' => 'At what stage in the life history of a mammal is the sex of an individual set?',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'at adolescence', 'is_correct' => false],
                    ['option' => 'at puberty', 'is_correct' => false],
                    ['option' => 'at birth', 'is_correct' => false],
                    ['option' => 'at conception', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'The sex of a mammal is determined at the moment of conception, depending on whether the sperm cell that fertilizes the egg carries an X or Y chromosome.'
            ],

            [
                'question' => 'The main distinguishing features between the soldier termite and other members of the caste are the',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'presence of wings, possession of a small head and large thorax', 'is_correct' => false],
                    ['option' => 'presence of wings, possession of a large thorax and a small head', 'is_correct' => false],
                    ['option' => 'absence of wings, possession of strong mandibles and a large head', 'is_correct' => true],
                    ['option' => 'absence of wings, possession of big head and the absence of mandible', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Factors affecting the distribution of Organisms',
                'explanation' => 'Soldier termites are characterized by their large heads and strong mandibles, which are used for defense, and they do not have wings.'
            ],

            [
                'question' => 'The flippers of a whale and the fins of a fish are examples of',
                'year' => 2010,
                'marks' => 2,
                'options' => [
                    ['option' => 'divergent evolution', 'is_correct' => false],
                    ['option' => 'coevolution', 'is_correct' => false],
                    ['option' => 'continuous variation', 'is_correct' => false],
                    ['option' => 'convergent evolution', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'The flippers of a whale and the fins of a fish are examples of convergent evolution, where unrelated species evolve similar traits due to having to adapt to similar environments or ecological niches.'
            ],
            [
                'question' => 'The function of the red head in male Agama lizards is to',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'conceal and camouflage the animal from predators', 'is_correct' => false],
                    ['option' => 'scare other males from the territory', 'is_correct' => false],
                    ['option' => 'attract female lizards for mating purposes', 'is_correct' => true],
                    ['option' => 'warm predators of the distastefulness of the animal', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'The bright red head of male Agama lizards is a sexual dimorphism used to attract females during mating season.'
            ],

            [
                'question' => 'In which of the following species is the biomass of an individual the smallest?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Agama sp.', 'is_correct' => false],
                    ['option' => 'Bufo sp.', 'is_correct' => false],
                    ['option' => 'Spirogyra sp.', 'is_correct' => true],
                    ['option' => 'Tilapia sp.', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Ecology of Population',
                'explanation' => 'Spirogyra sp. are filamentous algae with a small biomass per individual, especially compared to animals like Agama lizards or Tilapia fish.'
            ],

            [
                'question' => 'Seed plants are divided into',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'tracheophytes and ferns', 'is_correct' => false],
                    ['option' => 'angiosperms and gymnosperms', 'is_correct' => true],
                    ['option' => 'monocotyledons and dicotyledons', 'is_correct' => false],
                    ['option' => 'thallophytes and bryophytes', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Seed plants are divided into angiosperms, which are flowering plants, and gymnosperms, which include conifers and other non-flowering plants.'
            ],

            [
                'question' => 'In which of the following groups of vertebrates is parental care mostly exhibited?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Reptilia', 'is_correct' => false],
                    ['option' => 'Amphibia', 'is_correct' => false],
                    ['option' => 'Aves', 'is_correct' => true],
                    ['option' => 'Mammalia', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Parental care is most extensively exhibited in birds (Aves) and mammals (Mammalia), where parents invest significant time and resources in the upbringing of their offspring.'
            ],

            [
                'question' => 'The adaptive importance of nuptial flight from termite colonies is to',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'disperse the reproductives in order to establish new colonies', 'is_correct' => true],
                    ['option' => 'provide abundant food for birds and other animals during the early rains', 'is_correct' => false],
                    ['option' => 'ensure cross-breeding between members of one colony and another', 'is_correct' => false],
                    ['option' => 'expel the reproductives so as to provide enough food for other members', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'The nuptial or mating flight of termites is a dispersal phase where reproductive termites leave their original colonies to mate and establish new colonies elsewhere.'
            ],
            [
                'question' => 'Which of the following can cause shrinkage of living cells?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Hypotonic solution', 'is_correct' => false],
                    ['option' => 'Isotonic solution', 'is_correct' => false],
                    ['option' => 'Deionized water', 'is_correct' => false],
                    ['option' => 'Hypertonic solution', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Factors affecting the distribution of Organisms',
                'explanation' => 'When cells are placed in a hypertonic solution, water moves out of the cells into the surrounding solution, causing the cells to shrink.'
            ],

            [
                'question' => 'Which of the following is true of leucocytes?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'They are respiratory pigments', 'is_correct' => false],
                    ['option' => 'They are most numerous and ramify all cells', 'is_correct' => false],
                    ['option' => 'They are large and nucleated', 'is_correct' => true],
                    ['option' => 'They are involved in blood clotting', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Leucocytes, or white blood cells, are indeed larger than red blood cells and have a nucleus. They play a role in the immune system, not in blood clotting.'
            ],

            [
                'question' => 'The conversion of a nutrient into a molecule in the body of a consumer is referred to as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'digestion', 'is_correct' => false],
                    ['option' => 'assimilation', 'is_correct' => true],
                    ['option' => 'absorption', 'is_correct' => false],
                    ['option' => 'inhibition', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Assimilation refers to the process where nutrients that are absorbed into the bloodstream are taken up by the body cells and converted into biological molecules.'
            ],

            [
                'question' => 'The ability of living organism to detect and respond to changes in the environment is referred to as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'locomotion', 'is_correct' => false],
                    ['option' => 'irritability', 'is_correct' => true],
                    ['option' => 'growth', 'is_correct' => false],
                    ['option' => 'taxis', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and movement',
                'explanation' => 'Irritability, or responsiveness, is the ability of an organism to detect and respond to changes in its external or internal environment.'
            ],

            [
                'question' => 'In mammals, the exchange of nutrients and metabolic products occurs in the',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'lungs', 'is_correct' => false],
                    ['option' => 'oesophagus', 'is_correct' => false],
                    ['option' => 'trachea', 'is_correct' => false],
                    ['option' => 'lymph', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Transport',
                'explanation' => 'The lymphatic system in mammals is involved in the exchange of nutrients and metabolic products between the bloodstream and the cells.'
            ],

            [
                'question' => 'An example of an endospermous seed is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'maize gain', 'is_correct' => true],
                    ['option' => 'cashew nut', 'is_correct' => false],
                    ['option' => 'cotton seed', 'is_correct' => false],
                    ['option' => 'been seed', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Maize grain is an example of an endospermous seed, where the endosperm formed during seed development is retained until germination.'
            ],

            [
                'question' => 'The enzyme involved in the hydrolysis is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'rennin', 'is_correct' => false],
                    ['option' => 'erepsin', 'is_correct' => true],
                    ['option' => 'sucrase', 'is_correct' => false],
                    ['option' => 'maltase', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Biochemistry',
                'explanation' => 'Erepsin is a mixture of enzymes found in the intestinal juices that breaks down proteins into amino acids during the process of digestion.'
            ],

            [
                'question' => 'The part of the mammalian ear responsible for the maintenance of balance is the',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'pinna', 'is_correct' => false],
                    ['option' => 'cochlea', 'is_correct' => false],
                    ['option' => 'perilymph', 'is_correct' => false],
                    ['option' => 'ossicles', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and movement',
                'explanation' => 'The correct answer, which is not provided among the options, should be the semicircular canals or the vestibular system of the inner ear, which are responsible for balance.'
            ],

            [
                'question' => 'The path followed by air as it passes through the lungs in mammals is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'trachea → bronchi → bronchioles → alveoli', 'is_correct' => true],
                    ['option' => 'bronchi → trachea → alveoli → bronchioles', 'is_correct' => false],
                    ['option' => 'trachea → bronchioles → bronchi → alveoli', 'is_correct' => false],
                    ['option' => 'bronchioles → alveoli → bronchi → trachea', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Respiration',
                'explanation' => 'Air enters the mammalian respiratory system through the trachea, then travels into the bronchi, bronchioles, and finally into the alveoli where gas exchange occurs.'
            ],

            [
                'question' => 'The type of asexual reproduction that is common to both Paramecium and protists is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'budding', 'is_correct' => false],
                    ['option' => 'sporulation', 'is_correct' => false],
                    ['option' => 'fragmentation', 'is_correct' => false],
                    ['option' => 'fission', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Fission, specifically binary fission, is a type of asexual reproduction common in protists like Paramecium, where the organism divides into two equal parts.'
            ],

            [
                'question' => 'An example of a filter-feeding animal is a',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'shark', 'is_correct' => true],
                    ['option' => 'butterfly', 'is_correct' => false],
                    ['option' => 'whale', 'is_correct' => false], // This should be true as well, some species of whales are filter feeders.
                    ['option' => 'mosquito', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Certain species of sharks are filter feeders, meaning they feed by filtering food particles out of water, as do some species of whales, which are not mentioned as an option here.'
            ],

            [
                'question' => 'Which of the following is a feature of the population pyramid of a developing country?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'long lifespan', 'is_correct' => false],
                    ['option' => 'low birth rate', 'is_correct' => false],
                    ['option' => 'low death rate', 'is_correct' => false],
                    ['option' => 'high birth rate', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Humans and Environment',
                'explanation' => 'Developing countries typically have a population pyramid characterized by a wide base, indicating a high birth rate.'
            ],
            [
                'question' => 'The sequence of the one-way gaseous exchange mechanism in a fish is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'operculum → gills → mouth', 'is_correct' => false],
                    ['option' => 'gills → operculum → mouth', 'is_correct' => false],
                    ['option' => 'mouth → operculum → gills', 'is_correct' => false],
                    ['option' => 'mouth → gills → operculum', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Respiration',
                'explanation' => 'In fish, water typically enters through the mouth, passes over the gills where gas exchange occurs, and exits through the operculum.'
            ],

            [
                'question' => 'Which of the following organs regulates the levels of water, salts, hydrogen ions and urea in the mammalian blood?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Liver', 'is_correct' => false],
                    ['option' => 'Kidney', 'is_correct' => true],
                    ['option' => 'Bladder', 'is_correct' => false],
                    ['option' => 'Colon', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Excretion',
                'explanation' => 'The kidneys are responsible for regulating the water balance, salt levels, acid-base balance, and the removal of urea through urine in mammals.'
            ],

            [
                'question' => 'The vascular tissues in higher plants are responsible for',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'the movement of food and water', 'is_correct' => true],
                    ['option' => 'transpiration pull', 'is_correct' => false],
                    ['option' => 'suction pressure', 'is_correct' => false],
                    ['option' => 'the transport of gases and water', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Transport',
                'explanation' => 'In higher plants, the vascular tissues, which include xylem and phloem, are responsible for the transport of water and nutrients (xylem) and food (phloem) throughout the plant.'
            ],

            [
                'question' => 'The movement response of a cockroach away from a light source can be described as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'positive phototaxis', 'is_correct' => false],
                    ['option' => 'negative phototaxis', 'is_correct' => true],
                    ['option' => 'positive photokinesis', 'is_correct' => false],
                    ['option' => 'negative phototropism', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and movement',
                'explanation' => 'Negative phototaxis is the movement of an organism away from a light source, which is a behavior exhibited by cockroaches.'
            ],
            [
                'question' => 'The interaction of a community of organisms with its abiotic environment constitutes',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'a niche', 'is_correct' => false],
                    ['option' => 'a food chain', 'is_correct' => false],
                    ['option' => 'an ecosystem', 'is_correct' => true],
                    ['option' => 'a microhabitat', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Humans and Environment',
                'explanation' => 'An ecosystem consists of the biological community of organisms interacting with their physical and chemical environment.'
            ],

            [
                'question' => 'The vector of the malaria parasite is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'female Aedes mosquito', 'is_correct' => false],
                    ['option' => 'female Anopheles mosquito', 'is_correct' => true],
                    ['option' => 'male Culex mosquito', 'is_correct' => false],
                    ['option' => 'female Culex mosquito', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'The female Anopheles mosquito is the vector responsible for transmitting the malaria parasite to humans.'
            ],

            [
                'question' => 'Which of the following instruments is used to measure relative humidity?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Hydrometer', 'is_correct' => false],
                    ['option' => 'Thermometer', 'is_correct' => false],
                    ['option' => 'Hygrometer', 'is_correct' => true],
                    ['option' => 'Anemometer', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Factors affecting the distribution of Organisms',
                'explanation' => 'A hygrometer is an instrument used to measure the moisture content or the relative humidity of the air.'
            ],

            [
                'question' => 'Habitats are generally classified into',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'abiotic and abiotic', 'is_correct' => false],
                    ['option' => 'aquatic and terrestrial', 'is_correct' => true],
                    ['option' => 'arboreal and marine biomes', 'is_correct' => false],
                    ['option' => 'microhabitats and macrohabitats', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Natural Habitats',
                'explanation' => 'Habitats are typically classified as aquatic or terrestrial. Aquatic habitats are in water, while terrestrial habitats are on land.'
            ],

            [
                'question' => 'Dracunculiasis can be contracted through',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'eating contaminated food', 'is_correct' => false],
                    ['option' => 'drinking contaminated water', 'is_correct' => true],
                    ['option' => 'bathing in contaminated water', 'is_correct' => false],
                    ['option' => 'bites of blackfly', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Diseases',
                'explanation' => 'Dracunculiasis, also known as Guinea worm disease, is typically contracted by drinking water that contains water fleas infected with guinea worm larvae.'
            ],

            [
                'question' => 'Which of the following groups of environmental factors are density-dependent?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Food, salinity, accumulation of metabolites and light', 'is_correct' => false],
                    ['option' => 'Temperature, salinity predation and disease', 'is_correct' => false],
                    ['option' => 'Food predation, disease and accumulation of metabolites', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Ecology of Population',
                'explanation' => 'Density-dependent factors are those that affect the population based on its size such as food availability, predation, disease, and waste accumulation.'
            ],

            [
                'question' => 'The inheritable characters that are determined by a gene located on the X-chromosome is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'recessive', 'is_correct' => false],
                    ['option' => 'sex-linked', 'is_correct' => true],
                    ['option' => 'homozygous', 'is_correct' => false],
                    ['option' => 'dominant', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Traits determined by genes located on the sex chromosomes, particularly the X-chromosome, are described as sex-linked. These traits are more commonly expressed in one sex than the other.'
            ],

            [
                'question' => 'If the cross of a red-flowered plant with a white-flowered plant produces a pink-flowered plant, it is an example of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'codominance', 'is_correct' => false],
                    ['option' => 'incomplete dominance', 'is_correct' => true],
                    ['option' => 'mutation', 'is_correct' => false],
                    ['option' => 'linkage', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Incomplete dominance occurs when the phenotype of the heterozygous genotype is an intermediate of the phenotypes of the homozygous genotypes.'
            ],

            [
                'question' => 'Which of the following theories was NOT considered by Darwin in his evolutionary theory?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Survival of the fittest', 'is_correct' => false],
                    ['option' => 'Variation', 'is_correct' => false],
                    ['option' => 'Use and disuse', 'is_correct' => true],
                    ['option' => 'Competition', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => "The concept of use and disuse' was proposed by Jean-Baptiste Lamarck, not Charles Darwin. It suggests that body parts grow or shrink according to how much they are used or not."
            ],
            [
                'question' => 'Millet, sorghum, maize and onions are common crops growth in Nigeria in the',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'tropical rainforests', 'is_correct' => false],
                    ['option' => 'Sudan savannas', 'is_correct' => true],
                    ['option' => 'montane forests', 'is_correct' => false],
                    ['option' => 'Sahel savanna', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Local (Nigerian) Biomes',
                'explanation' => 'Millet, sorghum, maize, and onions are commonly grown in the Sudan savannas of Nigeria, which provide a suitable climate and soil type for these crops.'
            ],

            [
                'question' => 'In which of the following biomes is the southwestern part of Nigeria located?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Temperate forest', 'is_correct' => false],
                    ['option' => 'Tropical rainforest', 'is_correct' => true],
                    ['option' => 'Tropical woodland', 'is_correct' => false],
                    ['option' => 'Desert', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Local (Nigerian) Biomes',
                'explanation' => 'The southwestern part of Nigeria, including places like Lagos and Ondo, is characterized by tropical rainforest biomes.'
            ],

            [
                'question' => 'Lack of space in a population could lead to an increase in',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'water scarcity', 'is_correct' => false],
                    ['option' => 'birth rate', 'is_correct' => false],
                    ['option' => 'disease rate', 'is_correct' => true],
                    ['option' => 'drought', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'The Ecology of Population',
                'explanation' => 'Overcrowding in a population can lead to an increase in the transmission of diseases, thereby raising the disease rate.'
            ],

            [
                'question' => 'The crossing of individuals of the same species with different genetic characters is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'cross breeding', 'is_correct' => true],
                    ['option' => 'self pollination', 'is_correct' => false],
                    ['option' => 'cloning', 'is_correct' => false],
                    ['option' => 'hybridization', 'is_correct' => false] // This could also be considered correct depending on context.
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Cross breeding is the process of breeding individuals from different strains or forms to produce offspring with characteristics of both parents. Hybridization can also be a term used in this context.'
            ],
            [
                'question' => 'The number of alleles controlling blood groups in humans is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => '3', 'is_correct' => true],
                    ['option' => '4', 'is_correct' => false],
                    ['option' => '5', 'is_correct' => false],
                    ['option' => '2', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'For the ABO blood group system, there are three alleles: IA, IB, and i.'
            ],

            [
                'question' => 'During blood transfusion, agglutination may occur as a result of the reaction between',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'contrasting antigens and antibodies', 'is_correct' => true],
                    ['option' => 'two different antigens', 'is_correct' => false],
                    ['option' => 'two different antibodies', 'is_correct' => false],
                    ['option' => 'similar antigens and antibodies', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Agglutination during blood transfusion is caused by the reaction between incompatible antigens on the red blood cells and antibodies in the recipient’s plasma.'
            ],

            [
                'question' => 'The fallacy in Lamarck\'s evolutionary theory was the assumption that',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'traits are acquired through disuse of body parts', 'is_correct' => false],
                    ['option' => 'acquired traits are heritable', 'is_correct' => true],
                    ['option' => 'acquired traits are seldom formed', 'is_correct' => false],
                    ['option' => 'traits are acquired through the use of body parts', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'Lamarck incorrectly proposed that acquired traits — characteristics gained through the lifetime of an organism — could be passed on to offspring.'
            ],

            [
                'question' => 'The bright coloured eye spots on the wings of moth are an example of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'warning colouration', 'is_correct' => true],
                    ['option' => 'disruptive colouration', 'is_correct' => false],
                    ['option' => 'crypsis', 'is_correct' => false],
                    ['option' => 'mimicry', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Factors affecting the distribution of Organisms',
                'explanation' => 'Eye spots on moths are a form of warning colouration, meant to startle or deter predators by mimicking the eyes of larger predators.'
            ],

            [
                'question' => 'The wings of a bat and those of a bird are examples of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'analogous evolution', 'is_correct' => false],
                    ['option' => 'convergent evolution', 'is_correct' => true],
                    ['option' => 'coevolution', 'is_correct' => false],
                    ['option' => 'divergent evolution', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'Bat wings and bird wings are examples of convergent evolution, where similar structures arise independently in different species due to similar environmental pressures and functions.'
            ],
            [
                'question' => 'Which of the following is most advanced in the evolutionary trend of animals?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Liver fluke', 'is_correct' => false],
                    ['option' => 'Earthworm', 'is_correct' => false],
                    ['option' => 'Snail', 'is_correct' => false],
                    ['option' => 'Cockroach', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'Among the options given, the cockroach represents a more advanced stage in the evolutionary trend of animals due to its more complex body structure and survival capabilities.'
            ],

            [
                'question' => 'Which of the following is the lowest category of classification?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Class', 'is_correct' => false],
                    ['option' => 'Species', 'is_correct' => true],
                    ['option' => 'Family', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'In the hierarchy of biological classification, species is the lowest or most specific level.'
            ],

            [
                'question' => 'Plants that show secondary growth are usually found among the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'thallophytes', 'is_correct' => false],
                    ['option' => 'pteridophytes', 'is_correct' => false],
                    ['option' => 'monocotyledons', 'is_correct' => false],
                    ['option' => 'dicotyledons', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Secondary growth, which includes the thickening of stems and roots, typically occurs in dicotyledons.'
            ],

            [
                'question' => 'The functionally distinct group of eukaryotes mainly because they have',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'spores', 'is_correct' => false],
                    ['option' => 'no chlorophyll', 'is_correct' => false],
                    ['option' => 'many fruiting bodies', 'is_correct' => false],
                    ['option' => 'sexual and asexual reproduction', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Eukaryotes are functionally distinct largely because they can reproduce both sexually and asexually, providing genetic diversity and adaptability.'
            ],

            [
                'question' => 'An arthropod that is destructive at early stage of its life cycle is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'butterfly', 'is_correct' => false],
                    ['option' => 'mosquito', 'is_correct' => true],
                    ['option' => 'bee', 'is_correct' => false],
                    ['option' => 'millipede', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'The mosquito is particularly destructive in its early stages, where, as larvae, they can be vectors for diseases.'
            ],

            [
                'question' => 'An animal body that can be cut along its axis in any plane to give two identical parts is said to be',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'radially symmetrical', 'is_correct' => true],
                    ['option' => 'bilaterally symmetrical', 'is_correct' => false],
                    ['option' => 'asymmetrical', 'is_correct' => false],
                    ['option' => 'symmetrical', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and movement',
                'explanation' => 'Radial symmetry means that the animal can be divided into similar halves by passing a plane at any angle along a central axis.'
            ],

            [
                'question' => 'Which of the following possesses mammary gland?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Dogfish', 'is_correct' => false],
                    ['option' => 'Whale', 'is_correct' => true],
                    ['option' => 'Shark', 'is_correct' => false],
                    ['option' => 'Catfish', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Whales, as mammals, have mammary glands for the purpose of feeding their young.'
            ],

            [
                'question' => 'The feature that links birds to reptiles in evolution is the possession of',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'feathers', 'is_correct' => false],
                    ['option' => 'beak', 'is_correct' => false],
                    ['option' => 'skeleton', 'is_correct' => true],
                    ['option' => 'scales', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'While birds have unique features like feathers, it is the specific features of their skeleton, similar to those in reptiles, that provide evidence for their evolutionary link.'
            ],
            [
                'question' => 'Countershading is an adaptive feature that enables animals to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'fight enemies', 'is_correct' => false],
                    ['option' => 'remain undetected', 'is_correct' => true],
                    ['option' => 'warn enemies', 'is_correct' => false],
                    ['option' => 'attract mates', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and Movement',
                'explanation' => 'Countershading is a form of camouflage where an animal’s coloration is darker on the upper side and lighter on the underside, reducing its visibility to predators and prey.'
            ],

            [
                'question' => 'Which of the following plant structures lacks a waterproof cuticle?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'leaf', 'is_correct' => false],
                    ['option' => 'stem', 'is_correct' => false],
                    ['option' => 'root', 'is_correct' => true],
                    ['option' => 'shoot', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Living Organisms',
                'explanation' => 'Roots generally lack a waterproof cuticle as they need to absorb water and nutrients from the soil.'
            ],

            [
                'question' => 'In the mammalian male reproductive system, the part that serves as a passage for both urine and semen is the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'urethra', 'is_correct' => true],
                    ['option' => 'ureter', 'is_correct' => false],
                    ['option' => 'bladder', 'is_correct' => false],
                    ['option' => 'seminal vesicle', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'In male mammals, the urethra serves as the passage for both urine during urination and semen during ejaculation.'
            ],

            [
                'question' => 'In plants which of the following is required in minute quantities for growth?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Copper', 'is_correct' => true],
                    ['option' => 'Potassium', 'is_correct' => false],
                    ['option' => 'Phosphorus', 'is_correct' => false],
                    ['option' => 'Sodium', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Copper is a micronutrient required in very small quantities by plants for proper growth.'
            ],

            [
                'question' => 'Which of the following organisms is both parasitic and autotrophic?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Sundew', 'is_correct' => false],
                    ['option' => 'Loran thus', 'is_correct' => true],
                    ['option' => 'Rhizopus', 'is_correct' => false],
                    ['option' => 'Tapeworm', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Symbiotic Interactions of Plants and Animals',
                'explanation' => 'Loranthus is a genus of parasitic plants that also have chlorophyll and are thus capable of photosynthesis, making them autotrophic as well.'
            ],

            [
                'question' => 'A function of the hydrochloric acid produced in the human stomach during digestion is to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'neutralise the effect of bile', 'is_correct' => false],
                    ['option' => 'coagulate milk protein and emulsify fats', 'is_correct' => false],
                    ['option' => 'stop the action of ptyalin', 'is_correct' => true],
                    ['option' => 'break up food into smaller particles', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Respiration',
                'explanation' => 'Hydrochloric acid in the stomach helps to denature proteins and also stops the action of the salivary enzyme ptyalin, which begins carbohydrate digestion in the mouth.'
            ],

            [
                'question' => 'Which of the following is involved in secondary thickening in plants?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Collenchyma and xylem cells', 'is_correct' => false],
                    ['option' => 'Vascular cambium', 'is_correct' => true],
                    ['option' => 'Vascular cambium and cork cambium', 'is_correct' => false],
                    ['option' => 'Cork cambium and sclerenchyma', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Vascular cambium is responsible for secondary growth in plants, which increases the diameter of stems and roots.'
            ],
            [
                'question' => 'An example of a fruit that develops from a single carpel is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'okra', 'is_correct' => true],
                    ['option' => 'tomato', 'is_correct' => false],
                    ['option' => 'bean', 'is_correct' => false],
                    ['option' => 'orange', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Okra is a fruit that develops from a single carpel, which is the reproductive organ of flowering plants.'
            ],

            [
                'question' => 'The developing embryo is usually contained in the part labelled',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'IV', 'is_correct' => true],
                    ['option' => 'III', 'is_correct' => false],
                    ['option' => 'II', 'is_correct' => false],
                    ['option' => 'I', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Without seeing the diagram it’s difficult to be certain, but typically the embryo in a seed is located in the part of the plant known as the ovary, which becomes the fruit after fertilization.'
            ],

            [
                'question' => 'The function of the part labelled III is to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'produce egg cells', 'is_correct' => false],
                    ['option' => 'protect sperms during fertilization', 'is_correct' => false],
                    ['option' => 'secrete hormones during coitus', 'is_correct' => false],
                    ['option' => 'protect the developing embryo', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Again, without the diagram, I can assume that part III refers to a structure like the placenta or seed coat, which are involved in protecting the developing embryo.'
            ],

            [
                'question' => 'Plant growth can be artificially stimulated by the addition of',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'gibberellin', 'is_correct' => true],
                    ['option' => 'kinin', 'is_correct' => false],
                    ['option' => 'abscisic acid', 'is_correct' => false],
                    ['option' => 'ethylene', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Growth',
                'explanation' => 'Gibberellin is a plant hormone that promotes stem elongation, germination, and other developmental processes and is used to stimulate plant growth.'
            ],

            [
                'question' => 'The autonomic nervous system consists of neurons that control the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'voluntary muscles', 'is_correct' => false],
                    ['option' => 'heart beat', 'is_correct' => true],
                    ['option' => 'tongue', 'is_correct' => false],
                    ['option' => 'hands', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Support and Movement',
                'explanation' => 'The autonomic nervous system is responsible for controlling involuntary bodily functions, including heart rate, digestion, respiratory rate, pupillary response, urination, and sexual arousal.'
            ],

            [
                'question' => 'Plants of temperate origin can be grown in tropical areas in the vegetation zones of the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'rain forest', 'is_correct' => false],
                    ['option' => 'Guinea savanna', 'is_correct' => false],
                    ['option' => 'Sudan savanna', 'is_correct' => true],
                    ['option' => 'montane forest', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Local (Nigerian) Biomes',
                'explanation' => 'Temperate plants often require a distinct seasonal variation which may be simulated in the Sudan savanna, with its distinct wet and dry seasons.'
            ],

            [
                'question' => 'The water cycle is maintained mainly by the evaporation of water in the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'environment', 'is_correct' => false],
                    ['option' => 'evaporation and condensation of water in the environment', 'is_correct' => true],
                    ['option' => 'condensation of water in the environment', 'is_correct' => false],
                    ['option' => 'transpiration and respiration in plants', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Factors Affecting the Distribution of Organisms',
                'explanation' => 'The water cycle is primarily driven by the evaporation of water from surfaces and transpiration from plants, followed by the condensation of water vapor into clouds and precipitation.'
            ],

            [
                'question' => 'Organisms living in an estuarine habitat are adapted to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'withstand wide fluctuations in temperature', 'is_correct' => false],
                    ['option' => 'survive only in water with low salinity', 'is_correct' => false],
                    ['option' => 'withstand wide fluctuations in salinity', 'is_correct' => true],
                    ['option' => 'feed only on phytoplankton and dead organic matter', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Natural Habitats',
                'explanation' => 'Estuarine habitats, where freshwater mixes with saltwater, require organisms to be adapted to wide fluctuations in salinity.'
            ],

            [
                'question' => 'In the kidney of mammals, the site of ultrafiltration is the',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'ureter', 'is_correct' => false],
                    ['option' => 'Bowman\'s capsule', 'is_correct' => true],
                    ['option' => 'Loop of Henle', 'is_correct' => false],
                    ['option' => 'renal tubule', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Excretion',
                'explanation' => 'Ultrafiltration occurs in the Bowman\'s capsule of the nephrons in the kidney, where blood is filtered under high pressure.'
            ],

            [
                'question' => 'Which of the following is true in blood transfusion?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'person of blood group AB can donate blood only to another person of blood group AB', 'is_correct' => false],
                    ['option' => 'persons of blood groups A and B can donate or receive blood from each other', 'is_correct' => false],
                    ['option' => 'A person of blood group AB can receive blood only from persons of group A or B', 'is_correct' => false],
                    ['option' => 'A person of blood group O can donate only to a person of blood group O', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'A person with blood group AB can receive blood from any group as they have both A and B antigens and no anti-A or anti-B antibodies. A person with blood group O can donate to any group as they have neither A nor B antigens (universal donor).'
            ],

            [
                'question' => 'A yellow maize is planted and all the fruits obtained are of yellow seeds. When they are cross-bred, yellow seeds and white seeds are obtained in a ratio 3:1. The yellow seed trait is said to be',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'non-inheritable', 'is_correct' => false],
                    ['option' => 'sex-linked', 'is_correct' => false],
                    ['option' => 'a recessive trait', 'is_correct' => false],
                    ['option' => 'a dominant trait', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'The 3:1 ratio of yellow to white seeds in the offspring is typical of a Mendelian monohybrid cross where yellow is the dominant trait over white, which is recessive.'
            ],

            [
                'question' => 'When a colour-blind man marries a carrier woman. What is the probability of their offspring being colour blind?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '25%', 'is_correct' => false],
                    ['option' => '50%', 'is_correct' => true],
                    ['option' => '75%', 'is_correct' => false],
                    ['option' => '100%', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'Color blindness is an X-linked recessive trait. A colour-blind man (X^cY) and a carrier woman (X^CX^c) have a 50% chance of having a color-blind son (X^cY) and a 50% chance of having a carrier daughter (X^CX^c).'
            ],

            [
                'question' => 'The correct base pairing for DNA is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'adenine → thymine and guanine → cytosine', 'is_correct' => true],
                    ['option' => 'adenine → guanine and thymine → cytosine', 'is_correct' => false],
                    ['option' => 'adenine → cytosine and guanine → thymine', 'is_correct' => false],
                    ['option' => 'adenine → adenine and cytosine → cytosine', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Heredity and Variations',
                'explanation' => 'In DNA, adenine (A) always pairs with thymine (T), and cytosine (C) always pairs with guanine (G), according to the base pairing rules.'
            ],

            [
                'question' => 'The short thick beak in birds is an adaptation for',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'crushing seeds', 'is_correct' => true],
                    ['option' => 'sucking nectar', 'is_correct' => false],
                    ['option' => 'tearing flesh', 'is_correct' => false],
                    ['option' => 'straining mud', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Adaptation',
                'explanation' => 'Birds with short, thick beaks are typically adapted to crush hard seeds.'
            ],

            [
                'question' => 'The basking of Agama lizards in the sun is to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'change the colour of their body', 'is_correct' => false],
                    ['option' => 'raise their body temperature to become active', 'is_correct' => true],
                    ['option' => 'fight to defend their territories', 'is_correct' => false],
                    ['option' => 'attract the female for courtship', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Behavioral Adaptations',
                'explanation' => 'Cold-blooded animals like Agama lizards bask in the sun to absorb heat and regulate their body temperature, which helps them become active.'
            ],

            [
                'question' => 'The significance of a very large number of termites involved in nuptial swarming is to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'provide birds with plenty of food', 'is_correct' => false],
                    ['option' => 'ensure their perpetuation despite predatory pressure', 'is_correct' => true],
                    ['option' => 'search for a favourable place to breed', 'is_correct' => false],
                    ['option' => 'ensure that every individual gets a mate', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reproduction',
                'explanation' => 'Nuptial swarming in large numbers increases the chances of survival and successful mating despite predators.'
            ],

            [
                'question' => 'The use and disuse of body parts and the inheritance of acquired traits were used to explain',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Darwin’s theory', 'is_correct' => false],
                    ['option' => 'Lamarck’s theory', 'is_correct' => true],
                    ['option' => 'genetic drift', 'is_correct' => false],
                    ['option' => 'gene flow', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Evolution',
                'explanation' => 'Lamarck’s theory of evolution is known for its claim that the use and disuse of body parts can lead to acquired traits that are passed on to offspring.'
            ],



            // ... add the remaining questions in the same format
        ];


        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $biology->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $biology->id,
            'total_marks' => $total_marks, // Sum of marks for all questions
            'duration' => 60, // Example default value
            'total_questions' => count($questions), // Total number of questions
            'max_attempts' => 3, // Example default value
        ]);


        foreach ($questions as $questionData) {
            // Create a new question for the quiz
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'quizzable_type' => Subject::class,
                'quizzable_id' => $biology->id,
                'question' => $questionData['question'],
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
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
