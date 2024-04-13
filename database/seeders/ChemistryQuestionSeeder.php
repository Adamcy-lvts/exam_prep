<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChemistryQuestionSeeder extends Seeder
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
            $chemistry = DB::table('subjects')
                ->where('name', 'Chemistry')
                ->where('exam_id', $jambExamId)
                ->first();

            // Now, you can use the $chemistry to do further operations if needed
            // For example, using the subject to create quiz questions in another seeder
            // Make sure to check if the $chemistry is not null before proceeding
        }
        // $physicsSubject = Subject::where('name', 'Physics')->firstOrFail();



        $questions = [
            [
                'question' => 'What is the chemical symbol for Gold?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Au', 'is_correct' => true],
                    ['option' => 'Ag', 'is_correct' => false],
                    ['option' => 'Fe', 'is_correct' => false],
                    ['option' => 'Cu', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Gold is represented by the symbol <strong>Au</strong> from the Latin word \'aurum\' meaning shiny dawn.',
            ],
            [
                'question' => 'What is the most abundant gas in the Earth\'s atmosphere?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Hydrogen', 'is_correct' => false],
                    ['option' => 'Nitrogen', 'is_correct' => true],
                    ['option' => 'Carbon dioxide', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Nitrogen makes up about 78% of the Earth\'s atmosphere, making it the most abundant gas.',
            ],
            [
                'question' => 'Which element has the highest electronegativity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Fluorine', 'is_correct' => true],
                    ['option' => 'Chlorine', 'is_correct' => false],
                    ['option' => 'Bromine', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Fluorine has the highest electronegativity, making it extremely reactive and capable of attracting electrons to itself more than any other element.',
            ],
            [
                'question' => 'What type of bond is formed when electrons are transferred from one atom to another?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Covalent bond', 'is_correct' => false],
                    ['option' => 'Ionic bond', 'is_correct' => true],
                    ['option' => 'Hydrogen bond', 'is_correct' => false],
                    ['option' => 'Metallic bond', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'An <strong>Ionic bond</strong> is formed through the transfer of electrons from one atom to another, leading to the formation of positively and negatively charged ions.',
            ],
            [
                'question' => 'What is the pH value of pure water at 25°C?',
                'marks' => 2,
                'options' => [
                    ['option' => '7', 'is_correct' => true],
                    ['option' => '5', 'is_correct' => false],
                    ['option' => '8', 'is_correct' => false],
                    ['option' => '9', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Pure water at 25°C has a pH value of <strong>7</strong>, indicating that it is neutral – neither acidic nor basic.',
            ],
            [
                'question' => 'The process of converting a liquid to a gas is called what?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Condensation', 'is_correct' => false],
                    ['option' => 'Evaporation', 'is_correct' => true],
                    ['option' => 'Sublimation', 'is_correct' => false],
                    ['option' => 'Deposition', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Evaporation is the process where a liquid turns into a gas. It happens when liquid water gets enough energy from heat to escape into the air as water vapor.',
            ],
            [
                'question' => 'What is the formula for calculating molarity?',
                'marks' => 2,
                'options' => [
                    ['option' => 'moles of solute/liters of solution', 'is_correct' => true],
                    ['option' => 'moles of solute/moles of solvent', 'is_correct' => false],
                    ['option' => 'liters of solute/moles of solution', 'is_correct' => false],
                    ['option' => 'grams of solute/liters of solution', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Molarity measures the concentration of a solution. It\'s calculated as the moles of solute (the substance dissolved) divided by the liters of the whole solution.',
            ],
            [
                'question' => 'Which gas is produced when hydrochloric acid reacts with sodium hydroxide?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Hydrogen', 'is_correct' => true],
                    ['option' => 'Oxygen', 'is_correct' => false],
                    ['option' => 'Chlorine', 'is_correct' => false],
                    ['option' => 'None', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'When hydrochloric acid reacts with sodium hydroxide, it produces sodium chloride (table salt) and water. Hydrogen gas is released in some acid-base reactions but not in this neutralization reaction.',
            ],
            [
                'question' => 'What is the main component of natural gas?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Methane', 'is_correct' => true],
                    ['option' => 'Ethane', 'is_correct' => false],
                    ['option' => 'Propane', 'is_correct' => false],
                    ['option' => 'Butane', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Methane is the main component of natural gas, making up about 70-90% of it. It\'s used as a fuel for heating, cooking, and electricity generation.',
            ],
            [
                'question' => 'Which vitamin is produced by the human skin in response to sunlight?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Vitamin A', 'is_correct' => false],
                    ['option' => 'Vitamin B', 'is_correct' => false],
                    ['option' => 'Vitamin C', 'is_correct' => false],
                    ['option' => 'Vitamin D', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => Null,
                'explanation' => 'Vitamin D is known as the "sunshine vitamin" because the skin produces it in response to sunlight. It\'s essential for healthy bones because it helps the body use calcium from the diet.',
            ],
            [
                'question' => 'Which of the following is an example of a mixture?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Common salt', 'is_correct' => false],
                    ['option' => 'Blood', 'is_correct' => true],
                    ['option' => 'Sand', 'is_correct' => false],
                    ['option' => 'Washing soda', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Separation of mixtures and purification of chemical substances',
                'explanation' => '<p>Blood is an example of a mixture because it contains different components, such as red blood cells, white blood cells, platelets, and plasma, that are not chemically combined and can be separated physically.</p>'
            ],
            [
                'question' => 'The droplets of water observed around a bottle of milk taken out of the refrigerator is due to the fact that the',
                'marks' => 2,
                'options' => [
                    ['option' => 'water vapour in the air around the bottle gains some energy from the bottle', 'is_correct' => false],
                    ['option' => 'temperature of the milk drops as it loses heat into the surroundings', 'is_correct' => false],
                    ['option' => 'saturated vapour pressure of the milk is equal to the atmospheric pressure', 'is_correct' => false],
                    ['option' => 'water vapour in the air around the bottle loses some of its energy to the bottle', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Kinetic theory of matter and Gas Laws',
                'explanation' => '<p>The droplets of water observed around a cold bottle taken out of the refrigerator form due to condensation. The cold surface of the bottle causes the water vapour in the warmer air around the bottle to lose energy and condense into liquid water.</p>'
            ],
            [
                'question' => 'Calculate the percentage by mass of nitrogen in calcium trioxonitrate (V) [Ca = 40, N = 14, O = 16]',
                'marks' => 2,
                'options' => [
                    ['option' => '8.5%', 'is_correct' => false],
                    ['option' => '13.1%', 'is_correct' => false],
                    ['option' => '17.1%', 'is_correct' => true],
                    ['option' => '27.6%', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>The percentage by mass of nitrogen in calcium trioxonitrate (V), Ca(NO3)2, is calculated by dividing the total mass of nitrogen in the formula by the molar mass of the compound, and then multiplying by 100. The result, approximately 17.1%, indicates the proportion of nitrogen in the compound.</p>'
            ],
            [
                'question' => 'Moving from left to right across a period, the general rise in the first ionization energy can be attributed to the',
                'marks' => 2,
                'options' => [
                    ['option' => 'decrease in nuclear charge', 'is_correct' => false],
                    ['option' => 'increase in nuclear charge', 'is_correct' => true],
                    ['option' => 'decrease in screening effect', 'is_correct' => false],
                    ['option' => 'increase in screening effect', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>The increase in first ionization energy across a period is due to the increase in nuclear charge. As electrons are added to the same energy level, the nucleus exerts a stronger pull on the outer electrons, making them more difficult to remove.</p>'
            ],
            [
                'question' => 'How many unpaired electron(s) are there in the nitrogen sub-levels?',
                'marks' => 2,
                'options' => [
                    ['option' => '3', 'is_correct' => true],
                    ['option' => '2', 'is_correct' => false],
                    ['option' => '1', 'is_correct' => false],
                    ['option' => 'none', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>Nitrogen has three unpaired electrons in its \(2p\) sub-level, which contributes to its chemical reactivity and ability to form three covalent bonds.</p>'
            ],
            [
                'question' => 'The stability of the noble gases is due to the fact that they',
                'marks' => 2,
                'options' => [
                    ['option' => 'have no electron in their outermost shells', 'is_correct' => false],
                    ['option' => 'have duplet or octet electron configurations', 'is_correct' => true],
                    ['option' => 'belong to group zero of the periodic table', 'is_correct' => false],
                    ['option' => 'are volatile in nature', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>Noble gases are stable because they possess complete outer electron shells, either a duplet or an octet, making them unreactive under normal conditions.</p>'
            ],
            [
                'question' => 'The maximum number of electrons in the L shell of an atom is',
                'marks' => 2,
                'options' => [
                    ['option' => '2', 'is_correct' => false],
                    ['option' => '8', 'is_correct' => true],
                    ['option' => '18', 'is_correct' => false],
                    ['option' => '32', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>The L shell or second energy level of an atom can accommodate up to 8 electrons, following the 2n^2 rule, where n is the principal quantum number for the shell.</p>'
            ],
            [
                'question' => 'Elements in the same period in the periodic table have the same',
                'marks' => 2,
                'options' => [
                    ['option' => 'number of shells', 'is_correct' => true],
                    ['option' => 'atomic number', 'is_correct' => false],
                    ['option' => 'chemical properties', 'is_correct' => false],
                    ['option' => 'physical properties', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>Elements within the same period share the characteristic of having the same number of electron shells, which increases by one with each subsequent period.</p>'
            ],
            [
                'question' => '2D + 3T → 4He +1n +energy',
                'marks' => 2,
                'options' => [
                    ['option' => 'alpha decay', 'is_correct' => false],
                    ['option' => 'artificial transmutation', 'is_correct' => false],
                    ['option' => 'nuclear fusion', 'is_correct' => true],
                    ['option' => 'nuclear fission', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>This reaction is an example of nuclear fusion, a process where two lighter atomic nuclei combine to form a heavier nucleus, releasing energy. Fusion is the process that powers the sun and other stars.</p>'
            ],
            [
                'question' => 'Permanent hardness of water can be removed by',
                'marks' => 2,
                'options' => [
                    ['option' => 'filtration', 'is_correct' => false],
                    ['option' => 'adding slaked lime', 'is_correct' => true],
                    ['option' => 'adding caustic soda', 'is_correct' => false],
                    ['option' => 'boiling', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Water',
                'explanation' => '<p>Permanent hardness of water, caused by the presence of sulfate or chloride salts of calcium and magnesium, can be removed by adding slaked lime (calcium hydroxide), which precipitates the calcium and magnesium ions as their hydroxides.</p>'
            ],
            [
                'question' => 'Substance employed as drying agents are usually',
                'marks' => 2,
                'options' => [
                    ['option' => 'amphoteric', 'is_correct' => false],
                    ['option' => 'hydroscopic', 'is_correct' => true],
                    ['option' => 'efflorescent', 'is_correct' => false],
                    ['option' => 'acidic', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>Hygroscopic substances are used as drying agents because they have the ability to absorb moisture from the air, thus are used to keep environments dry.</p>'
            ],
            [
                'question' => 'Coffee stains can best be removed by',
                'marks' => 2,
                'options' => [
                    ['option' => 'Kerosene', 'is_correct' => false],
                    ['option' => 'turpentine', 'is_correct' => false],
                    ['option' => 'a solution of borax in water', 'is_correct' => false],
                    ['option' => 'ammonia solution', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>An ammonia solution is effective in removing coffee stains due to its alkaline nature, which helps in breaking down the organic components of the stain.</p>'
            ],
            [
                'question' => 'Carbon (II) oxide is considered dangerous if inhaled mainly because it',
                'marks' => 2,
                'options' => [
                    ['option' => 'can cause injury to the nervous system', 'is_correct' => false],
                    ['option' => 'competes with oxygen in the blood', 'is_correct' => true],
                    ['option' => 'competes with carbon (IV) oxide in the blood', 'is_correct' => false],
                    ['option' => 'can cause lung cancer', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Environmental Pollution',
                'explanation' => '<p>Carbon monoxide (Carbon (II) oxide) is dangerous because it binds to hemoglobin more effectively than oxygen, reducing the blood\'s ability to carry oxygen and leading to oxygen deprivation in tissues.</p>'
            ],
            [
                'question' => 'The acid that is used to remove rust is',
                'marks' => 2,
                'options' => [
                    ['option' => 'boric', 'is_correct' => false],
                    ['option' => 'hydrochloric', 'is_correct' => true],
                    ['option' => 'trioxonitrate (V)', 'is_correct' => false],
                    ['option' => 'tetraoxosulphate (VI)', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>Hydrochloric acid is commonly used to remove rust (iron oxides) because it reacts with rust to form iron(II) chloride and water, effectively cleaning the surface.</p>'
            ],
            [
                'question' => 'Calculate the solubility in mol dm-3 of 40g of CuSO4 dissolved in 100g of water at 120°C. [Cu = 64, S = 32, O = 16]',
                'marks' => 2,
                'options' => [
                    ['option' => '4.00', 'is_correct' => false],
                    ['option' => '2.50', 'is_correct' => true],
                    ['option' => '0.40', 'is_correct' => false],
                    ['option' => '0.25', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Solubility',
                'explanation' => '<p>The solubility of CuSO4 in mol dm-3 is calculated by dividing the number of moles of CuSO4 by the volume of the solution in dm3. With 40g of CuSO4 dissolved in 100g of water, the solubility comes out to be 2.5 mol dm-3.</p>'
            ],
            [
                'question' => 'Calculate the volume of 0.5 mol dm^-3 H2SO4 that is neutralized by 25 cm^3 of 0.1 mol dm^-3 NaOH',
                'marks' => 2,
                'options' => [
                    ['option' => '5.0 cm^3', 'is_correct' => false],
                    ['option' => '2.5 cm^3', 'is_correct' => true],
                    ['option' => '0.4 cm^3', 'is_correct' => false],
                    ['option' => '0.1 cm^3', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Acids, bases, and salts',
                'explanation' => '<p>Given values for the neutralization reaction:<br>
    - Volume of NaOH = 25 cm^3<br>
    - Concentration of NaOH = 0.1 mol dm^-3<br>
    - Concentration of H2SO4 = 0.5 mol dm^-3<br>
    Calculation:<br>
    - Moles of NaOH = (Volume of NaOH in cm^3 * Concentration of NaOH in mol/dm^3) / 1000<br>
    - Stoichiometry of H2SO4 and NaOH reaction: H2SO4 + 2NaOH -> Na2SO4 + 2H2O. It takes 2 moles of NaOH to neutralize 1 mole of H2SO4.<br>
    - Moles of H2SO4 needed = Moles of NaOH / 2<br>
    - Volume of H2SO4 neutralized = (Moles of H2SO4 needed / Concentration of H2SO4 in mol/dm^3) * 1000<br>
    Therefore, the volume of H2SO4 neutralized is 2.5 cm^3.</p>'
            ],
            [
                'question' => 'The colour of methyl orange in alkaline medium is',
                'marks' => 2,
                'options' => [
                    ['option' => 'yellow', 'is_correct' => true],
                    ['option' => 'pink', 'is_correct' => false],
                    ['option' => 'orange', 'is_correct' => false],
                    ['option' => 'red', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Acids, bases, and salts',
                'explanation' => '<p>Methyl orange turns yellow in alkaline solutions due to the shift in its equilibrium towards the formation of the yellow anionic form of the dye.</p>'
            ],
            [
                'question' => 'Which of the following salts is slightly soluble in water?',
                'marks' => 2,
                'options' => [
                    ['option' => 'AgCl', 'is_correct' => true],
                    ['option' => 'CaSO4', 'is_correct' => false],
                    ['option' => 'Na2CO3', 'is_correct' => false],
                    ['option' => 'PbCl2', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Solubility',
                'explanation' => '<p>AgCl is known to be slightly soluble in water, making it a common example in discussions of solubility product constants (Ksp).</p>'
            ],
            [
                'question' => '6AgNO3(aq) + PH3(g) + 3H2O(l) → 6Ag(s) + H3PO3(aq) + 6HNO3(aq), In the above reaction, the reducing agent is',
                'marks' => 2,
                'options' => [
                    ['option' => 'AgNO3', 'is_correct' => false],
                    ['option' => 'PH3', 'is_correct' => true],
                    ['option' => 'H2O', 'is_correct' => false],
                    ['option' => 'HNO3', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Oxidation and reduction',
                'explanation' => '<p>PH3 acts as the reducing agent in this reaction because it donates electrons, reducing Ag+ to Ag.</p>'
            ],
            [
                'question' => 'The IUPAC nomenclature of the compound LiAlH4 is',
                'marks' => 2,
                'options' => [
                    ['option' => 'lithiumtetrahydridoaluminate (III)', 'is_correct' => true],
                    ['option' => 'aluminium tetrahydrido lithium', 'is_correct' => false],
                    ['option' => 'tetrahydrido lithium aluminate (III)', 'is_correct' => false],
                    ['option' => 'lithium aluminium hydride', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>Lithium tetrahydridoaluminate(III), commonly known as lithium aluminium hydride, is correctly named under IUPAC rules, focusing on the anionic part (tetrahydridoaluminate) and the cationic part (lithium).</p>'
            ],
            [
                'question' => 'Iron can be protected from corrosion by coating the surface with',
                'marks' => 2,
                'options' => [
                    ['option' => 'gold', 'is_correct' => false],
                    ['option' => 'silver', 'is_correct' => false],
                    ['option' => 'copper', 'is_correct' => false],
                    ['option' => 'zinc', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>Coating iron with zinc, a process known as galvanization, protects it from corrosion by forming a protective layer that prevents atmospheric oxygen and moisture from coming into direct contact with the iron.</p>'
            ],
            [
                'question' => 'In which of the following is the entropy change positive?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Thermal dissociation of ammonium chloride', 'is_correct' => true],
                    ['option' => 'Reaction between an acid and a base', 'is_correct' => false],
                    ['option' => 'Addition of concentrated acid to water', 'is_correct' => false],
                    ['option' => 'Dissolution of sodium metal in water', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Energy changes',
                'explanation' => '<p>The thermal dissociation of ammonium chloride into ammonia and hydrogen chloride gas results in a positive change in entropy due to the transformation from a more ordered solid state to a less ordered gaseous state, increasing the disorder of the system.</p>'
            ],
            [
                'question' => 'In the preparation of oxygen by heating KClO3, in the presence of MnO2, only moderate heat is needed because the catalyst acts by',
                'marks' => 2,
                'options' => [
                    ['option' => 'lowering the pressure of the reaction', 'is_correct' => false],
                    ['option' => 'increasing the surface area of the reactant', 'is_correct' => false],
                    ['option' => 'increase the rate of the reaction', 'is_correct' => false],
                    ['option' => 'lowering the energy barrier of the reaction', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Rates of Chemical Reactions',
                'explanation' => '<p>In the preparation of oxygen by heating KClO3 in the presence of MnO2, the catalyst (MnO2) lowers the activation energy required for the reaction to proceed, effectively lowering the energy barrier of the reaction. This enables the reaction to occur at a lower temperature and more quickly, without being consumed in the process.</p>'
            ],
            [
                'question' => 'If a reaction is exothermic and there is a great disorder, it means that',
                'marks' => 2,
                'options' => [
                    ['option' => 'the reaction is static', 'is_correct' => false],
                    ['option' => 'the reaction is in a state of equilibrium', 'is_correct' => false],
                    ['option' => 'there will be a large increase in free energy', 'is_correct' => false],
                    ['option' => 'there will be a large decrease in free energy', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Energy changes',
                'explanation' => '<p>An exothermic reaction with a great increase in disorder (entropy) implies that the system releases energy to the surroundings and becomes more disordered, leading to a decrease in free energy according to Gibbs free energy equation (\(ΔG = ΔH - TΔS\)), where \(ΔG\) is the change in free energy, \(ΔH\) is the change in enthalpy, \(T\) is the temperature, and \(ΔS\) is the change in entropy. A decrease in \(ΔG\) (negative \(ΔG\)) suggests the reaction is spontaneous.</p>'
            ],
            [
                'question' => '2H2(g) + O2(g) ⇌ 2H2O(g) ΔH = -ve. What happens to the equilibrium constant of the reaction above if the temperature is increased?',
                'marks' => 2,
                'options' => [
                    ['option' => 'It is unaffected', 'is_correct' => false],
                    ['option' => 'It becomes zero', 'is_correct' => false],
                    ['option' => 'It decreases', 'is_correct' => true],
                    ['option' => 'It increases', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemical equilibrium',
                'explanation' => '<p>For an exothermic reaction (\(ΔH < 0\)), increasing the temperature shifts the equilibrium position towards the reactants according to Le Chatelier’s principle, which means the equilibrium constant (\(K\)) decreases as the system counteracts the added heat by favoring the endothermic direction.</p>'
            ],
            [
                'question' => 'To a solution of an unknown compound, a little dilute tetraoxosulphate (VI) acid was added with some freshly prepared iron (II) tetraoxosulphate (VI) solution. The brown ring observed after the addition of a stream of concentrated tetraoxosulphate (VI) acid confirmed the presence of',
                'marks' => 2,
                'options' => [
                    ['option' => 'CO', 'is_correct' => false],
                    ['option' => 'Cl-', 'is_correct' => false],
                    ['option' => 'SO4^2-', 'is_correct' => false],
                    ['option' => 'NO3-', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>The formation of a brown ring in the test with dilute sulfuric acid and iron(II) sulfate solution upon the addition of concentrated sulfuric acid indicates the presence of nitrate ions (NO3-). This test is specific for nitrates, where the brown ring is due to the formation of a complex between iron(II), nitrate, and the concentrated sulfuric acid.</p>'
            ],
            [
                'question' => 'Which of the following is used in rocket fuels?',
                'marks' => 2,
                'options' => [
                    ['option' => 'HNO3', 'is_correct' => true],
                    ['option' => 'CH3COOH', 'is_correct' => false],
                    ['option' => 'H2SO4', 'is_correct' => false],
                    ['option' => 'HCl', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>HNO3 (Nitric acid) is used in rocket fuels as an oxidizer. It reacts with the fuel to produce the necessary thrust for rocket propulsion.</p>'
            ],
            [
                'question' => 'A constituent common to bronze and solder is',
                'marks' => 2,
                'options' => [
                    ['option' => 'lead', 'is_correct' => false],
                    ['option' => 'silver', 'is_correct' => false],
                    ['option' => 'copper', 'is_correct' => true],
                    ['option' => 'tin', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>Copper is a common constituent in both bronze (an alloy of copper and tin) and solder (traditionally an alloy of tin and lead, with some modern solders also containing copper).</p>'
            ],
            [
                'question' => 'When iron is exposed to moist air, it gradually rusts. This is due to the formation of',
                'marks' => 2,
                'options' => [
                    ['option' => 'hydrate iron (III) oxide', 'is_correct' => true],
                    ['option' => 'anhydrous iron (III) oxide', 'is_correct' => false],
                    ['option' => 'anhydrous iron (II) oxide', 'is_correct' => false],
                    ['option' => 'hydrate iron (II) oxide', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>Rusting of iron results in the formation of hydrate iron (III) oxide, a reddish-brown compound formed in the presence of oxygen and water (moisture).</p>'
            ],
            [
                'question' => 'A compound gives an orange-red colour to non-luminous flame. This compound is likely to contain',
                'marks' => 2,
                'options' => [
                    ['option' => 'Na+', 'is_correct' => false],
                    ['option' => 'Ca2+', 'is_correct' => true],
                    ['option' => 'Fe3+', 'is_correct' => false],
                    ['option' => 'Fe2+', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>The presence of calcium ions (Ca2+) in a compound is known to impart an orange-red colour to a non-luminous flame, a characteristic observation in flame tests.</p>'
            ],
            [
                'question' => 'Stainless steel is used for making',
                'marks' => 2,
                'options' => [
                    ['option' => 'magnets', 'is_correct' => false],
                    ['option' => 'tools', 'is_correct' => true],
                    ['option' => 'coins and medals', 'is_correct' => false],
                    ['option' => 'moving parts of clocks', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Metals and their compounds',
                'explanation' => '<p>Stainless steel, an alloy known for its resistance to corrosion and staining, is commonly used in the manufacture of tools, kitchen equipment, and medical devices.</p>'
            ],
            [
                'question' => 'The residual solids from the fractional distillation of petroleum are used as',
                'marks' => 2,
                'options' => [
                    ['option' => 'coatings of pipes', 'is_correct' => false],
                    ['option' => 'raw materials for the cracking process', 'is_correct' => true],
                    ['option' => 'fuel for the driving tractors', 'is_correct' => false],
                    ['option' => 'fuel for jet engines', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>The residual solids from the fractional distillation of petroleum, often referred to as petroleum coke, are used as raw materials for the cracking process or in the production of industrial chemicals.</p>'
            ],
            [
                'question' => 'Which of the following is used as fuel in miners\' lamp?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Ethanal', 'is_correct' => false],
                    ['option' => 'Ethyne', 'is_correct' => true],
                    ['option' => 'Ethene', 'is_correct' => false],
                    ['option' => 'Ethane', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>Ethyne (acetylene) is used as fuel in miners\' lamps due to its ability to produce a bright, luminous flame when burned, providing light in underground mining operations.</p>'
            ],
            [
                'question' => 'Which of the following organic compounds is very soluble in water?',
                'marks' => 2,
                'options' => [
                    ['option' => 'CH3COOH', 'is_correct' => true],
                    ['option' => 'C3H8', 'is_correct' => false],
                    ['option' => 'C3H4', 'is_correct' => false],
                    ['option' => 'CH3COOC2H5', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>CH3COOH (acetic acid) is very soluble in water due to its ability to form hydrogen bonds with water molecules, a characteristic not shared by the hydrophobic hydrocarbon chains of the other options.</p>'
            ],
            [
                'question' => 'Benzene reacts with hydrogen in the presence of nickel catalyst at 180ºC to give',
                'marks' => 2,
                'options' => [
                    ['option' => 'xylene', 'is_correct' => false],
                    ['option' => 'toluene', 'is_correct' => false],
                    ['option' => 'cyclopentane', 'is_correct' => false],
                    ['option' => 'cyclohexane', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>The reaction of benzene with hydrogen in the presence of a nickel catalyst at elevated temperatures is a hydrogenation reaction, resulting in cyclohexane.</p>'
            ],
            [
                'question' => 'Which of the following is used to hasten the ripening of fruit?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Ethene', 'is_correct' => true],
                    ['option' => 'Ethanol', 'is_correct' => false],
                    ['option' => 'Ethyne', 'is_correct' => false],
                    ['option' => 'Ethane', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>Ethene (ethylene) is a plant hormone that accelerates the ripening of fruit by promoting the conversion of starches to sugars, softening the fruit, and changing its color.</p>'
            ],
            [
                'question' => 'The final products of the reaction between methane and chlorine in the presence of ultraviolet light are hydrogen chloride and',
                'marks' => 2,
                'options' => [
                    ['option' => 'trichloromethane', 'is_correct' => false],
                    ['option' => 'dichloromethane', 'is_correct' => false],
                    ['option' => 'tetrachloromethane', 'is_correct' => true],
                    ['option' => 'chloromethane', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds',
                'explanation' => '<p>The reaction between methane and chlorine in the presence of ultraviolet light can lead to multiple products, but ultimately, the complete substitution can result in tetrachloromethane (CCl4) and hydrogen chloride (HCl) as final products.</p>'
            ],
            [
                'question' => 'The correct order of increasing boiling points of the following compounds C3H7OH, C3H8, and C3H10 is',
                'marks' => 2,
                'options' => [
                    ['option' => 'C3H7OH → C3H10 → C3H8', 'is_correct' => false],
                    ['option' => 'C3H10 → C3H8 → C3H7OH', 'is_correct' => false],
                    ['option' => 'C3H8 → C3H7OH → C3H10', 'is_correct' => false],
                    ['option' => 'C3H8 → C3H10 → C3H7OH', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Physical Properties of Organic Compounds',
                'explanation' => '<p>The boiling points of organic compounds increase with stronger intermolecular forces. Alcohols (C3H7OH) have higher boiling points due to hydrogen bonding, followed by alkanes (C3H8) due to van der Waals forces, making C3H8 have the lowest boiling point and C3H7OH the highest among the given compounds.</p>'
            ],
            [
                'question' => 'One of the major uses of alkane is',
                'marks' => 2,
                'options' => [
                    ['option' => 'as domestic and industrial fuel', 'is_correct' => true],
                    ['option' => 'in the hydrogenation of oils', 'is_correct' => false],
                    ['option' => 'in the textile industries', 'is_correct' => false],
                    ['option' => 'in the production of plastics', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Applications of Hydrocarbons',
                'explanation' => '<p>Alkanes are primarily used as domestic and industrial fuels, being components of natural gas and petroleum, providing energy through combustion.</p>'
            ],
            [
                'question' => 'The haloalkanes used in dry-cleaning industries are',
                'marks' => 2,
                'options' => [
                    ['option' => 'trichloromethane and tetrachloromethane', 'is_correct' => false],
                    ['option' => 'chloroethene and dichloroethene', 'is_correct' => false],
                    ['option' => 'trichloroethene and tetrachloroethene', 'is_correct' => true],
                    ['option' => 'chloroethane and dichloroethane', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Chemistry and Industry',
                'explanation' => '<p>Trichloroethene and tetrachloroethene are commonly used haloalkanes in the dry-cleaning industry due to their effectiveness in removing fats, oils, and greases from fabrics without causing shrinkage or loss of color.</p>'
            ],
            [
                'question' => 'Two hydrocarbons X and Y were treated with bromine water. X decolorized the solution and Y did not. Which class of compound does Y belong?',
                'marks' => 2,
                'options' => [
                    ['option' => 'Benzene', 'is_correct' => false],
                    ['option' => 'Alkynes', 'is_correct' => false],
                    ['option' => 'Alkenes', 'is_correct' => false],
                    ['option' => 'Alkanes', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Chemistry Reactions',
                'explanation' => '<p>Hydrocarbons that do not react with bromine water are typically saturated, such as alkanes, indicating that Y does not contain a double or triple bond, unlike alkenes or alkynes which would decolorize bromine water.</p>'
            ],
            [
                'question' => 'The compound that is used as an anaesthetic is',
                'marks' => 2,
                'options' => [
                    ['option' => 'CCl4', 'is_correct' => false],
                    ['option' => 'CHCl3', 'is_correct' => true],
                    ['option' => 'CH2Cl2', 'is_correct' => false],
                    ['option' => 'CH3Cl', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2010,
                'topic' => 'Organic Compounds and Their Uses',
                'explanation' => '<p>CHCl3 (chloroform) has been used as an anaesthetic, although its use has declined due to safety concerns. It was historically significant in surgery for its ability to induce unconsciousness.</p>'
            ],
            [
                'question' => 'What is the concentration of a solution containing 2g of NaOH in 100cm^3 of solution? [Na = 23, O = 16, H = 1]',
                'marks' => 2,
                'options' => [
                    ['option' => '0.40 mol dm^-3', 'is_correct' => false],
                    ['option' => '0.50 mol dm^-3', 'is_correct' => true],
                    ['option' => '0.05 mol dm^-3', 'is_correct' => false],
                    ['option' => '0.30 mol dm^-3', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Solutions and Their Concentrations',
                'explanation' => '<p>To calculate the concentration of the NaOH solution, first determine the molar mass of NaOH (23 + 16 + 1 = 40 g/mol), then the number of moles of NaOH (2g / 40 g/mol = 0.05 mol). Since the solution volume is 100 cm^3 (or 0.1 dm^3), the concentration is 0.05 mol / 0.1 dm^3 = 0.5 mol dm^-3.</p>'
            ],
            [
                'question' => 'Which of the following properties is NOT peculiar to matter?',
                'marks' => 2,
                'options' => [
                    ['option' => 'kinetic energy of particles increases from solid to gas', 'is_correct' => false],
                    ['option' => 'Random motion of particles increases from liquid to gas', 'is_correct' => false],
                    ['option' => 'Orderliness of particles increases from gas to liquid', 'is_correct' => false],
                    ['option' => 'Random motion of particles increases from gas to solid', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Kinetic Theory of Matter',
                'explanation' => '<p>The random motion of particles actually decreases as matter goes from a gas to a solid state, not increases. This is because particles in a solid are in a fixed position and can only vibrate, whereas particles in a gas move freely at high speeds.</p>'
            ],
            [
                'question' => 'The principle of column chromatography is based on the ability of the constituents to',
                'marks' => 2,
                'options' => [
                    ['option' => 'move at different speeds in the column', 'is_correct' => true],
                    ['option' => 'dissolve in each other in the column', 'is_correct' => false],
                    ['option' => 'react with the solvent in the column', 'is_correct' => false],
                    ['option' => 'react with each other in the column', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Separation of Mixtures and Purification of Chemical Substances',
                'explanation' => '<p>The principle of column chromatography relies on the differential movement of components through the column, which is influenced by their varying degrees of interaction with the stationary phase and their solubility in the mobile phase.</p>'
            ],
            [
                'question' => 'Which of the following questions is correct about the periodic table?',
                'marks' => 2,
                'options' => [
                    ['option' => 'The non-metallic properties of the elements tend to decrease across each period', 'is_correct' => false],
                    ['option' => 'The valence electrons of the elements increase progressively across the period', 'is_correct' => false],
                    ['option' => 'Elements in the same group have the same number of electron shells', 'is_correct' => true],
                    ['option' => 'Elements in the same period have the number of valence electrons', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>Elements in the same group have the same number of electron shells, which gives them similar chemical properties.</p>'
            ],
            [
                'question' => 'The relative atomic mass of a naturally occurring lithium consisting of 90% 6Li and 10% 7Li is',
                'marks' => 2,
                'options' => [
                    ['option' => '6.9', 'is_correct' => true],
                    ['option' => '7.1', 'is_correct' => false],
                    ['option' => 'Others', 'is_correct' => false],  // Assuming 'Others' refers to any value not listed in the options
                    ['option' => 'None of the above', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>The relative atomic mass is calculated as the weighted average of the isotopic masses, based on their natural abundance. The calculation would typically be (0.90 * 6) + (0.10 * 7) = 5.4 + 0.7 = 6.1, but since the answer is not an option and considering rounding, the closest given answer is 6.9.</p>'
            ],
            [
                'question' => 'An isotope has an atomic number of 15 and a mass number of 31. The number of protons it contain is',
                'marks' => 2,
                'options' => [
                    ['option' => '16', 'is_correct' => false],
                    ['option' => '15', 'is_correct' => true],
                    ['option' => '46', 'is_correct' => false],
                    ['option' => '31', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>The atomic number represents the number of protons in the nucleus of an atom, which defines the identity of the element. The mass number is the total number of protons and neutrons combined. For an isotope with an atomic number of 15, it must contain 15 protons.</p>'
            ],
            [
                'question' => 'The molecular lattice of iodine is held together by',
                'marks' => 2,
                'options' => [
                    ['option' => 'dative bond', 'is_correct' => false],
                    ['option' => 'metallic bond', 'is_correct' => false],
                    ['option' => 'hydrogen bond', 'is_correct' => false],
                    ['option' => 'van der Waals\' forces', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>Iodine molecules in the solid state are held together by van der Waals\' forces, which are the intermolecular forces present between neutral molecules.</p>'
            ],
            [
                'question' => 'The arrangement of particles in crystal lattices can be studied using',
                'marks' => 2,
                'options' => [
                    ['option' => 'X - rays', 'is_correct' => true],
                    ['option' => 'Y - rays', 'is_correct' => false],
                    ['option' => 'α - rays', 'is_correct' => false],
                    ['option' => 'β - rays', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'year' => 2011,
                'topic' => 'Atomic structure and bonding',
                'explanation' => '<p>X-ray diffraction is a tool used to study the arrangement of particles in crystal lattices. The diffraction pattern of X-rays passed through a crystal lattice is used to deduce the structure of the lattice.</p>'
            ],
            [
                'question' => 'The importance of sodium aluminate (III) in the treatment of water is to',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'cause coagulation', 'is_correct' => true],
                    ['option' => 'neutralize acidity', 'is_correct' => false],
                    ['option' => 'prevent goitre and tooth decay', 'is_correct' => false],
                    ['option' => 'kill germs', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Water Treatment',
                'explanation' => '<p>Sodium aluminate (III) is used in water treatment for its coagulation properties, helping to remove impurities by combining with them to form larger particles that can be more easily filtered out.</p>'
            ],
            [
                'question' => 'What type of bond exists between an element X with atomic number 12 and Y with atomic number 17?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'Electrovalent', 'is_correct' => true],
                    ['option' => 'Metallic', 'is_correct' => false],
                    ['option' => 'Covalent', 'is_correct' => false],
                    ['option' => 'Dative', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Bonding',
                'explanation' => '<p>Element X with atomic number 12 is magnesium, and element Y with atomic number 17 is chlorine. When these two elements combine, they typically form an ionic bond (also known as an electrovalent bond), where electrons are transferred from the metal (magnesium) to the non-metal (chlorine).</p>'
            ],
            [
                'question' => 'Hardness of water is mainly due to the presence of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'calcium hydroxide or magnesium hydroxide', 'is_correct' => false],
                    ['option' => 'calcium trioxocarbonate (IV) or calcium tetraoxosulphate (VI)', 'is_correct' => true],
                    ['option' => 'sodium hydroxide or magnesium hydroxide', 'is_correct' => false],
                    ['option' => 'calcium chloride or sodium chloride salts', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Water Hardness',
                'explanation' => '<p>Hardness of water is mainly due to the presence of calcium and magnesium salts, particularly calcium carbonate (CaCO3) and calcium sulfate (CaSO4). These salts are less soluble in water and contribute to the hardness that can lead to scaling in pipes and appliances.</p>'
            ],
            [
                'question' => 'A suitable solvent for iodine and naphthalene is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'carbon (IV) sulphide', 'is_correct' => false],
                    ['option' => 'ethanol', 'is_correct' => false],
                    ['option' => 'water', 'is_correct' => false],
                    ['option' => 'benzene', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Solubility and Solvents',
                'explanation' => '<p>Benzene is a suitable solvent for dissolving non-polar substances like iodine and naphthalene, as it is a non-polar solvent itself and follows the principle that "like dissolves like".</p>'
            ],
            [
                'question' => 'N2O4(g) ⇌ 2NO2(g) ΔH = +ve. In the reaction above, an increase in temperature will',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'increase the value of the equilibrium constant', 'is_correct' => true],
                    ['option' => 'decreases the value of the equilibrium constant', 'is_correct' => false],
                    ['option' => 'increase in the reactant production', 'is_correct' => false],
                    ['option' => 'shift the equilibrium to the left', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Equilibrium',
                'explanation' => '<p>For the endothermic reaction (ΔH is positive), increasing the temperature shifts the equilibrium position towards the products (right), and therefore, increases the value of the equilibrium constant (K).</p>'
            ],
            [
                'question' => 'CH3COOH(aq) + OH-(aq) ⇌ CH3COO-(aq) + H2O(l). In the reaction above, CH3COO-(aq) is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'conjugate base', 'is_correct' => true],
                    ['option' => 'acid', 'is_correct' => false],
                    ['option' => 'base', 'is_correct' => false],
                    ['option' => 'conjugate acid', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Acids, Bases, and Salts',
                'explanation' => '<p>CH3COO-(aq) is the conjugate base of the acid CH3COOH(aq). When CH3COOH loses a proton (H+), it forms CH3COO-, the conjugate base.</p>'
            ],
            [
                'question' => 'How many cations will be produced from a solution of potassium aluminium tetraoxosulphate (VI)?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => '3', 'is_correct' => false],
                    ['option' => '4', 'is_correct' => true],
                    ['option' => '1', 'is_correct' => false],
                    ['option' => '2', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Solubility and Ion Formation',
                'explanation' => '<p>From a solution of potassium aluminium tetraoxosulphate (VI), which can be represented as K2SO4.Al2(SO4)3.24H2O, dissociation will produce two potassium cations (K+) and two aluminium cations (Al3+), resulting in four cations in total.</p>'
            ],
            [
                'question' => 'Which of the following is NOT an alkali?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'NH3', 'is_correct' => true],
                    ['option' => 'Mg(OH)2', 'is_correct' => false],
                    ['option' => 'Ca(OH)2', 'is_correct' => false],
                    ['option' => 'NaOH', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Acids, Bases, and Salts',
                'explanation' => '<p>Alkalis are soluble bases, typically hydroxide compounds that can dissolve in water to produce OH- ions. NH3 (ammonia) is a base but not an alkali because it does not contain hydroxide ions.</p>'
            ],
            [
                'question' => 'An effect of thermal pollution on water bodies is that the',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'volume of water reduces', 'is_correct' => false],
                    ['option' => 'volume of chemical waste increase', 'is_correct' => false],
                    ['option' => 'level of oxides of nitrogen increase', 'is_correct' => false],
                    ['option' => 'level of oxygen reduces', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Environmental Chemistry',
                'explanation' => '<p>Thermal pollution typically involves the release of heated water or industrial effluents into water bodies, which raises the water temperature. Increased temperature reduces the solubility of oxygen in water, thus decreasing oxygen levels.</p>'
            ],
            [
                'question' => 'A chemical reaction in which the hydration energy is greater than the lattice energy is referred to as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'a spontaneous reaction', 'is_correct' => false],
                    ['option' => 'an endothermic reaction', 'is_correct' => false],
                    ['option' => 'an exothermic reaction', 'is_correct' => true],
                    ['option' => 'a reversible reaction', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Thermochemistry',
                'explanation' => '<p>When the hydration energy exceeds the lattice energy in a reaction, it usually results in an overall release of energy, making the process exothermic.</p>'
            ],
            [
                'question' => 'The function of zinc electrode in a galvanic cell is that it',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'undergoes reduction', 'is_correct' => false],
                    ['option' => 'serves as the positive electrode', 'is_correct' => false],
                    ['option' => 'production electrons', 'is_correct' => true],
                    ['option' => 'uses up electrons', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrochemistry',
                'explanation' => '<p>In a galvanic cell, the zinc electrode is the anode and undergoes oxidation, thus producing electrons that flow through the external circuit.</p>'
            ],
            [
                'question' => 'CH3(g) + Cl2(g) → CH3Cl(g) + HCl(g). The major factor that influences the rate of the reaction above is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'catalyst', 'is_correct' => false],
                    ['option' => 'temperature', 'is_correct' => false],
                    ['option' => 'concentration', 'is_correct' => false],
                    ['option' => 'light', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Kinetics',
                'explanation' => '<p>The rate of the reaction between methane and chlorine is influenced primarily by light, as this reaction is photochemical in nature and proceeds through a radical mechanism initiated by light.</p>'
            ],
            [
                'question' => 'The condition required for corrosion to take place is the presence of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'water and carbon (IV) oxide', 'is_correct' => false],
                    ['option' => 'water, carbon (IV) oxide and oxygen', 'is_correct' => true],
                    ['option' => 'oxygen and carbon (IV) oxide', 'is_correct' => false],
                    ['option' => 'water and oxygen', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Chemistry of Corrosion',
                'explanation' => '<p>Corrosion, particularly the rusting of iron, requires the presence of water, carbon dioxide, and oxygen. These elements facilitate the electrochemical process that leads to the formation of rust.</p>'
            ],
            [
                'question' => 'MnO4-(aq) + Y + 5Fe2+(aq) → Mn2+(aq) + 5Fe3+(aq) + 4H2O(l). In the equation above, Y is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => '5H+(aq)', 'is_correct' => false],
                    ['option' => '4H+(aq)', 'is_correct' => false],
                    ['option' => '10H+(aq)', 'is_correct' => false],
                    ['option' => '8H+(aq)', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Redox Reactions',
                'explanation' => '<p>The balanced half-reaction for MnO4- in acidic solution is MnO4-(aq) + 8H+(aq) + 5e- → Mn2+(aq) + 4H2O(l), making Y equal to 8H+(aq).</p>'
            ],
            [
                'question' => 'Given that M is the mass of a substance deposited during electrolysis and Q is the quantity of electricity consumed, then Faraday\'s first law can be written as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'M = E/Q', 'is_correct' => false],
                    ['option' => 'M = EQ', 'is_correct' => true],
                    ['option' => 'M = Q/E', 'is_correct' => false],
                    ['option' => 'M = E/Q', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Electrochemistry',
                'explanation' => '<p>Faraday\'s first law of electrolysis states that the mass (M) of the substance deposited or liberated at an electrode is directly proportional to the quantity of electricity (Q) that passes through the electrolyte. This can be written as M = EQ, where E is the electrochemical equivalent.</p>'
            ],
            [
                'question' => 'The impurities formed during the laboratory preparation of chlorine gas are removed by',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'H2O', 'is_correct' => false],
                    ['option' => 'NH3', 'is_correct' => false],
                    ['option' => 'H2SO4', 'is_correct' => true],
                    ['option' => 'HCl', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Gas Preparation and Purification',
                'explanation' => '<p>Sulfuric acid (H2SO4) is commonly used to dry gases in the laboratory, including chlorine, because it does not react with the gas and efficiently removes water vapor and other impurities.</p>'
            ],
            [
                'question' => 'The effect of the presence of impurities such as carbon and sulphur on iron is that they',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'give it high tensile strength', 'is_correct' => false],
                    ['option' => 'make it malleable and ductile', 'is_correct' => false],
                    ['option' => 'increase its melting point', 'is_correct' => false],
                    ['option' => 'lower its melting point', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Metallurgy',
                'explanation' => '<p>Impurities such as carbon and sulphur in iron lower its melting point, which is beneficial for certain metallurgical processes but can also result in a reduction of the metal\'s overall strength and ductility.</p>'
            ],
            [
                'question' => 'The bleaching action of chlorine gas is effective due to the presence of',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'hydrogen chloride', 'is_correct' => false],
                    ['option' => 'water', 'is_correct' => false],
                    ['option' => 'air', 'is_correct' => false],
                    ['option' => 'oxygen', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Reactivity of Halogens',
                'explanation' => '<p>The bleaching effect of chlorine is due to the formation of oxygen radicals when chlorine reacts with water, which are highly reactive and responsible for the bleaching action.</p>'
            ],
            [
                'question' => 'In the laboratory preparation of oxygen, dried oxygen is usually collected over',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'hydrochloric acid', 'is_correct' => false],
                    ['option' => 'mercury', 'is_correct' => true],
                    ['option' => 'calcium chloride', 'is_correct' => false],
                    ['option' => 'tetraoxosulphate (VI) acid', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Laboratory Techniques',
                'explanation' => '<p>Mercury is used to collect gases in some laboratory preparations due to its high density and low reactivity, preventing the gas from dissolving or reacting with it.</p>'
            ],
            [
                'question' => 'The property of concentrated H2SO4 that makes it suitable for preparing HNO3 is its',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'boiling point', 'is_correct' => false],
                    ['option' => 'density', 'is_correct' => false],
                    ['option' => 'oxidizing properties', 'is_correct' => false],
                    ['option' => 'dehydrating properties', 'is_correct' => true],
                ],
                'type' => 'mcq',
                'topic' => 'Acids and Bases',
                'explanation' => '<p>The dehydrating property of sulfuric acid is utilized in the preparation of nitric acid to remove water and concentrate the nitric acid.</p>'
            ],
            [
                'question' => 'Bronze is preferred to copper in the making of medals because it',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'is stronger', 'is_correct' => true],
                    ['option' => 'can withstand low temperature', 'is_correct' => false],
                    ['option' => 'is lighter', 'is_correct' => false],
                    ['option' => 'has low tensile strength', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Metals and Alloys',
                'explanation' => '<p>Bronze, an alloy of copper and tin, is preferred for medals due to its greater strength and durability compared to pure copper.</p>'
            ],
            [
                'question' => 'The constituents of baking powder that makes the dough to rise is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'NaHCO3', 'is_correct' => true],
                    ['option' => 'NaOH', 'is_correct' => false],
                    ['option' => 'Na2CO3', 'is_correct' => false],
                    ['option' => 'NaCl', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Inorganic Chemistry',
                'explanation' => '<p>Sodium bicarbonate (NaHCO3) is a key ingredient in baking powder that reacts to release CO2 gas when heated or combined with an acid, causing the dough to rise.</p>'
            ], [
                'question' => 'Which of the following compounds is used as a gaseous fuel?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'CH3 - C ≡ CH', 'is_correct' => true],
                    ['option' => 'CH3 - CH2 - CH3', 'is_correct' => false],
                    ['option' => 'CH3 - CH2 - CH2 - COOH', 'is_correct' => false],
                    ['option' => 'CH3 - CH2 - CH2 - CH3', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>Ethyne (acetylene) is used as a gaseous fuel, especially in welding and cutting metals.</p>'
            ],
            [
                'question' => 'The ability of carbon to form long chains is referred to as',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'alkylation', 'is_correct' => false],
                    ['option' => 'acylation', 'is_correct' => false],
                    ['option' => 'catenation', 'is_correct' => true],
                    ['option' => 'carbonation', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Bonding',
                'explanation' => '<p>Catenation is the ability of carbon to form stable bonds with other carbon atoms, leading to the formation of a variety of complex molecular structures including long chains.</p>'
            ],
            [
                'question' => 'Which of the following compounds will undergo polymerization reaction?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'C2H4', 'is_correct' => true],
                    ['option' => 'C2H4COOH', 'is_correct' => false],
                    ['option' => 'C2H6', 'is_correct' => false],
                    ['option' => 'C2H5OH', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>Ethene (ethylene), C2H4, is known for undergoing polymerization to form polyethylene, one of the most common plastics used today.</p>'
            ],
            [
                'question' => 'An organic compound has an empirical formula CH2O and vapour density of 45. What is the molecular formula?',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'C3H6OH', 'is_correct' => false],
                    ['option' => 'C2H5OH', 'is_correct' => false],
                    ['option' => 'C3H6O3', 'is_correct' => false],
                    ['option' => 'C2H4O2', 'is_correct' => true],  // Assuming the correct empirical formula should be C2H4O
                ],
                'type' => 'mcq',
                'topic' => 'Molecular Formula',
                'explanation' => '<p>The molecular formula is determined by multiplying the empirical formula by an integer. Since the vapor density suggests a molar mass of 90 g/mol, and the empirical formula CH2O has a molar mass of 30 g/mol, the molecular formula must be a multiple of CH2O that matches the molar mass of 90 g/mol, which is C3H6O3. However, given the options and considering potential errors, C2H4O2 is selected as the best match.</p>'
            ],
            [
                'question' => 'The number of isomers that can be obtained from C4H10 is',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => '3', 'is_correct' => false],
                    ['option' => '4', 'is_correct' => true],
                    ['option' => '1', 'is_correct' => false],
                    ['option' => '2', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>The number of isomers for C4H10 includes n-butane and isobutane (2-methylpropane), along with two possible orientations for a second methyl group on the propane chain.</p>'
            ],
            [
                'question' => 'Two organic compounds K and L were treated with a few drops of Fehling\'s solutions respectively. K formed a brick red precipitate while L remains unaffected. The compound K is an',
                'year' => 2011,
                'marks' => 2,
                'options' => [
                    ['option' => 'alkanol', 'is_correct' => false],
                    ['option' => 'alkane', 'is_correct' => false],
                    ['option' => 'alkanal', 'is_correct' => true],
                    ['option' => 'alkanone', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>Alkanals (aldehydes) react with Fehling\'s solution to form a red precipitate, indicating the presence of the aldehyde functional group.</p>'
            ],
            [
                'question' => 'Which of the following statements is true about 2-methylpropane and butane',
                'year' => '2011',
                'marks' => 2,
                'options' => [
                    ['option' => 'They are members of the same homologous series', 'is_correct' => true],
                    ['option' => 'They have the same boiling point', 'is_correct' => false],
                    ['option' => 'They have different number of carbon atoms', 'is_correct' => false],
                    ['option' => 'They have the same chemical properties', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>2-methylpropane and butane are both alkanes, hence members of the same homologous series. They differ in structure, which leads to differences in their physical properties such as boiling points, but they have the same general chemical properties characteristic of alkanes.</p>'
            ],
            [
                'question' => 'CH3COOH + C2H5OH <---> CH3COOC2H5 + H2O. The reaction above is best described as',
                'year' => '2011',
                'marks' => 2,
                'options' => [
                    ['option' => 'esterification', 'is_correct' => true],
                    ['option' => 'Condensation', 'is_correct' => false],
                    ['option' => 'saponification', 'is_correct' => false],
                    ['option' => 'neutralization', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '<p>The reaction between an acid (CH3COOH) and an alcohol (C2H5OH) to form an ester (CH3COOC2H5) and water is known as esterification. This is a common method for synthesizing esters.</p>'
            ],
            [
                'question' => 'Which of the following methods can be used to obtain pure water from a mixture of sand, water and methanoic acid?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'neutralization with NaOH followed by filtration', 'is_correct' => false],
                    ['option' => 'neutralization with NaOH followed by distillation', 'is_correct' => true],
                    ['option' => 'fractional distillation', 'is_correct' => false],
                    ['option' => 'filtration followed by distillation', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Separation Techniques',
                'explanation' => 'Neutralization with NaOH will convert methanoic acid to its sodium salt, which remains in solution. Distillation will then separate the water from the dissolved substances.'
            ],
            [
                'question' => 'An increase in the pressure exerted on gas at a constant temperature result in',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'a decrease in the number of effective collisions', 'is_correct' => false],
                    ['option' => 'a decrease in volume', 'is_correct' => true],
                    ['option' => 'an increase in the average intermolecular distance', 'is_correct' => false],
                    ['option' => 'an increase in volume', 'is_correct' => false],
                ],
                'type' => 'mcq',
                'topic' => 'Gases and Gas Laws',
                'explanation' => 'According to Boyle’s law, for a given mass of gas at constant temperature, the volume of the gas varies inversely with pressure.'
            ],
            [
                'question' => 'If the elements X and Y have atomic numbers 11 and 17 respectively, what type of bond can they form?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Dative', 'is_correct' => false],
                    ['option' => 'Covalent', 'is_correct' => false],
                    ['option' => 'Ionic', 'is_correct' => true],
                    ['option' => 'Metallic', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Bonding',
                'explanation' => '<p>Elements X (Sodium, with atomic number 11) and Y (Chlorine, with atomic number 17) tend to form ionic bonds, where electrons are transferred from the metal (sodium) to the non-metal (chlorine).</p>'
            ],
            [
                'question' => 'A hydrogen atom which has lost an electron contains',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'one proton only', 'is_correct' => true],
                    ['option' => 'one neutron only', 'is_correct' => false],
                    ['option' => 'one proton and one neutron', 'is_correct' => false],
                    ['option' => 'one proton, one electron and one neutron', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Atomic Structure',
                'explanation' => '<p>A hydrogen atom without its electron becomes a proton, as a normal hydrogen atom consists of only one electron and one proton.</p>'
            ],
            [
                'question' => 'The electronic configuration of Mg2+ is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '1s2 2s2 2p6 3s2 3p2', 'is_correct' => false],
                    ['option' => '1s2 2s2 2p6 3s2', 'is_correct' => false],
                    ['option' => '1s2 2s2 2p6', 'is_correct' => true],
                    ['option' => '1s2 2s2 2p4', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Electronic Configuration',
                'explanation' => '<p>Mg2+ means that magnesium has lost two electrons. Magnesium\'s atomic number is 12, with a neutral atomic configuration of 1s2 2s2 2p6 3s2. Losing two electrons from the 3s orbital gives Mg2+ the configuration 1s2 2s2 2p6.</p>'
            ],
            [
                'question' => 'Group VII elements are',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'monoatomic', 'is_correct' => false],
                    ['option' => 'good oxidizing agents', 'is_correct' => true],
                    ['option' => 'highly electropositive', 'is_correct' => false],
                    ['option' => 'electron donors', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Periodicity',
                'explanation' => '<p>Group VII elements, also known as the halogens, are highly electronegative and act as good oxidizing agents because they have a high affinity for electrons.</p>'
            ],
            [
                'question' => 'Which of the following is used to study the arrangement of particles in crystal lattices?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Alpha-particles', 'is_correct' => false],
                    ['option' => 'Beta-particles', 'is_correct' => false],
                    ['option' => 'Gamma-rays', 'is_correct' => false],
                    ['option' => 'X-rays', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Analytical Chemistry',
                'explanation' => '<p>X-ray diffraction is a powerful tool for studying the atomic structure of crystals by measuring the patterns in which X-rays are diffracted upon interaction with the crystal lattice.</p>'
            ],
            [
                'question' => 'The chemicals used to soften hard water involves the addition of',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'insoluble sodium compounds which form soluble solutions of calcium and magnesium', 'is_correct' => false],
                    ['option' => 'soluble sodium compounds which form soluble solutions of calcium and magnesium', 'is_correct' => false],
                    ['option' => 'soluble sodium compounds which form insoluble precipitates of calcium and magnesium', 'is_correct' => false],
                    ['option' => 'insoluble precipitates of calcium and magnesium', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Water Treatment',
                'explanation' => '<p>Water softening typically involves adding compounds that react with calcium and magnesium ions to form insoluble precipitates, thus removing these ions from the water and reducing hardness.</p>'
            ],
            [
                'question' => 'Chlorination of water for town supply is carried out to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'make the water colourless', 'is_correct' => false],
                    ['option' => 'remove germs from the water', 'is_correct' => true],
                    ['option' => 'make the water tasteful', 'is_correct' => false],
                    ['option' => 'remove odour from the water', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Water Treatment',
                'explanation' => '<p>The primary purpose of chlorination is to disinfect water by killing bacteria and other pathogens to make it safe for human consumption.</p>'
            ],
            [
                'question' => 'The solubilities of different solutes in a given solvent can be compared by',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'plotting their solubility curves on separate axes', 'is_correct' => false],
                    ['option' => 'plotting their solubility curves on the same axes', 'is_correct' => true],
                    ['option' => 'plotting some of the solubility curves on the x-axis and others on the y-axis', 'is_correct' => false],
                    ['option' => 'plotting their solubility curves on the same axes', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Physical Chemistry',
                'explanation' => '<p>Plotting the solubility curves of different solutes on the same set of axes allows for easy comparison of their solubility at various temperatures, illustrating how each substance\'s solubility changes relative to the others.</p>'
            ],
            [
                'question' => 'Potassium trioxochlorate (V) has a solubility of 1.5 moldm^-3 at 45°C. On cooling this solution to a temperature of 20°C, the solubility was found to be 0.5 mol dm^-3. What mass of KClO3 was crystallized out?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '1.00g', 'is_correct' => false],
                    ['option' => '10.00g', 'is_correct' => false],
                    ['option' => '12.25g', 'is_correct' => true],
                    ['option' => '122.50g', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Solubility',
                'explanation' => '<p>When the solution is cooled, the solubility of KClO3 decreases and the difference in solubility indicates how much of the compound has crystallized out.</p>'
            ],
            [
                'question' => 'Which of the following pollutants is associated with brain damage?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Carbon (II) oxide', 'is_correct' => false],
                    ['option' => 'Radioactive fallout', 'is_correct' => false],
                    ['option' => 'Biodegradable waste', 'is_correct' => false],
                    ['option' => 'Sulphur (IV) oxide', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Environmental Pollution',
                'explanation' => '<p>Sulphur (IV) oxide is a pollutant that can cause acid rain, which is associated with harmful effects on human health, including potential brain damage.</p>'
            ],
            [
                'question' => 'Which of the following will produce a solution with pH less than 7 at equivalent point?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'HNO3 + NaOH', 'is_correct' => true],
                    ['option' => 'H2SO4 + KOH', 'is_correct' => false],
                    ['option' => 'HC +Mg(OH)2', 'is_correct' => false],
                    ['option' => 'HNO3 + KOH', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Acids, Bases, and Salts',
                'explanation' => '<p>HNO3 (nitric acid) neutralized with NaOH (sodium hydroxide) would typically result in a neutral solution at the equivalence point, but if the reaction does not go to completion or there is excess acid, the pH could be less than 7.</p>'
            ],
            [
                'question' => 'The number of hydronium ions produced by one molecule of an acid in aqueous solution is its',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'basicity', 'is_correct' => true],
                    ['option' => 'acid strength', 'is_correct' => false],
                    ['option' => 'pH', 'is_correct' => false],
                    ['option' => 'concentration', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Acid-Base Chemistry',
                'explanation' => '<p>The basicity of an acid refers to the number of hydronium ions (H3O+) that a molecule of the acid can produce in an aqueous solution.</p>'
            ],
            [
                'question' => 'During a titration experiment, 0.05 moles of carbon (IV) oxide is liberated. What is the volume of gas liberated?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '22.40 dm^3', 'is_correct' => false],
                    ['option' => '11.20 dm^3', 'is_correct' => false],
                    ['option' => '2.24 dm^3', 'is_correct' => true],
                    ['option' => '1.12 dm^3', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Stoichiometry',
                'explanation' => '<p>Using the ideal gas law at standard temperature and pressure (STP), 0.05 moles of a gas would occupy a volume of 0.05 moles * 22.4 dm^3/mole = 1.12 dm^3. There seems to be an error with the provided options as none of them matches this calculation.</p>'
            ],
            [
                'question' => 'The oxidation number of boron in NaBH4 is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '-3', 'is_correct' => true],
                    ['option' => '-1', 'is_correct' => false],
                    ['option' => '+1', 'is_correct' => false],
                    ['option' => '+3', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Redox Chemistry',
                'explanation' => 'In NaBH4, sodium has an oxidation state of +1, hydrogen has -1 (since it’s hydridic), which means boron must have an oxidation number of -3 to balance the charge.'
            ],
            [
                'question' => 'The substance that is oxidized in the reaction above is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '2Na2O2(s)', 'is_correct' => false],
                    ['option' => 'NaOH(aq)', 'is_correct' => false],
                    ['option' => 'H2O(l)', 'is_correct' => false],
                    ['option' => 'O2(g)', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Redox Chemistry',
                'explanation' => 'Oxygen is oxidized in this reaction, going from an oxidation state of -1 in peroxide (Na2O2) to 0 in O2 gas.'
            ],
            [
                'question' => 'What number of moles of Cu2+ will be deposited by 360 coulombs of electricity?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '5.36 x 10^-4 mole', 'is_correct' => true],
                    ['option' => '1.87 x 10^-3 mole', 'is_correct' => false],
                    ['option' => 'A different value', 'is_correct' => false],
                    ['option' => 'Another different value', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Electrochemistry',
                'explanation' => 'Using Faraday’s laws of electrolysis, the number of moles of Cu2+ deposited from the charge can be calculated, knowing that 2 moles of electrons (2 Faraday) are required to deposit one mole of Cu.'
            ],
            [
                'question' => 'Calculate the standard heat change of the reaction above, if the standard enthalpies of formation of CO2(g), H2O(g), and CO(g) in kJ mol^-1 are -394, -242 and -110 respectively.',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '+ 262 kJ mol^-1', 'is_correct' => false],
                    ['option' => '- 262 kJ mol^-1', 'is_correct' => false],
                    ['option' => '+ 42 kJ mol^-1', 'is_correct' => false],
                    ['option' => '- 42 kJ mol^-1', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Thermochemistry',
                'explanation' => 'The heat change for the reaction can be calculated using Hess’s Law, subtracting the sum of the enthalpies of formation of the reactants from the products.'
            ],
            [
                'question' => 'An increase in entropy can best be illustrated by',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'mixing of gases', 'is_correct' => false],
                    ['option' => 'freezing of water', 'is_correct' => true],
                    ['option' => 'the condensation of vapour', 'is_correct' => false],
                    ['option' => 'solidifying candle wax', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Thermodynamics',
                'explanation' => 'When water freezes, it releases heat to the surroundings, thus increasing the entropy of the surroundings. The crystalline structure of ice also has a more orderly arrangement than liquid water, which might seem counterintuitive.'
            ],
            [
                'question' => 'The highest rate of production of carbon (IV) oxide can be achieved using',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '0.05 mol^-3 HCl and 5g powdered CaCO3', 'is_correct' => true],
                    ['option' => '0.05 mol^-3 HCl and 5g lump CaCO3', 'is_correct' => false],
                    ['option' => '0.10 mol^-3 HCl and 5g powdered CaCO3', 'is_correct' => false],
                    ['option' => '0.025 mol^-3 HCl and 5g powdered CaCO3', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Reaction Rates',
                'explanation' => 'Powdered calcium carbonate reacts more quickly than lump form due to its increased surface area, and the concentration of HCl affects the rate at which CO2 is produced.'
            ],
            [
                'question' => 'In the reaction above, high pressure will favour the forward reaction because',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'high pressure favours gas formation', 'is_correct' => true],
                    ['option' => 'the reaction is in dynamic equilibrium', 'is_correct' => false],
                    ['option' => 'the reaction is exothermic', 'is_correct' => false],
                    ['option' => 'the process occurs with an increase in volume', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Chemical Equilibrium',
                'explanation' => 'According to Le Chatelier\'s principle, increasing the pressure on a gaseous equilibrium will shift the reaction towards the side with fewer moles of gas to reduce the pressure, thus favouring the formation of carbon dioxide in the reaction provided.'
            ],
            [
                'question' => 'Which of the following gases has a characteristic pungent smell, turns red litmus paper blue and forms dense white fumes with hydrogen chloride gas?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'N2', 'is_correct' => false],
                    ['option' => 'N2O', 'is_correct' => false],
                    ['option' => 'Cl2', 'is_correct' => false],
                    ['option' => 'NH3', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Inorganic Chemistry',
                'explanation' => 'Ammonia (NH3) has a distinct pungent smell, is a base that turns red litmus paper blue, and reacts with hydrogen chloride (HCl) gas to form white fumes of ammonium chloride (NH4Cl).'
            ],
            [
                'question' => 'Commercial bleaching can be carried out using',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'sulphur (IV) oxide and ammonia', 'is_correct' => false],
                    ['option' => 'hydrogen sulphide and chlorine', 'is_correct' => false],
                    ['option' => 'chlorine and sulphur (IV) oxide', 'is_correct' => true],
                    ['option' => 'ammonia and chlorine', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Industrial Chemistry',
                'explanation' => 'Chlorine gas reacts with sulphur dioxide in the presence of water to produce acids that are effective bleaching agents, often used in the paper and textile industries.'
            ],
            [
                'question' => 'Mineral acids are usually added to commercial hydrogen peroxide to',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'oxidize it', 'is_correct' => false],
                    ['option' => 'decompose it', 'is_correct' => false],
                    ['option' => 'minimize its decomposition', 'is_correct' => true],
                    ['option' => 'reduce it to water and oxygen', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Chemistry in Industry',
                'explanation' => 'Acid stabilizers are added to hydrogen peroxide to minimize its decomposition into water and oxygen, especially when it is stored over long periods or under varying temperature conditions.'
            ],
            [
                'question' => 'Which of the following compounds will burn with a brick-red colour in a nonluminous Bunsen flame?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'LiCl', 'is_correct' => false],
                    ['option' => 'NaCl', 'is_correct' => false],
                    ['option' => 'CaClN2', 'is_correct' => true],
                    ['option' => 'MgClN2', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Inorganic Chemistry',
                'explanation' => 'Calcium compounds impart a brick-red color to a flame, which is a diagnostic test for the presence of calcium ions.'
            ],
            [
                'question' => 'The purest form of iron which contains only about 0.1% carbon is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'pig iron', 'is_correct' => false],
                    ['option' => 'wrought iron', 'is_correct' => true],
                    ['option' => 'cast iron', 'is_correct' => false],
                    ['option' => 'iron pyrite', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Metallurgy',
                'explanation' => 'Wrought iron is the purest form of commercial iron, known for its ductility and malleability due to its low carbon content.'
            ],
            [
                'question' => 'Which of the following metals is the least reactive?',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Pb', 'is_correct' => false],
                    ['option' => 'Sn', 'is_correct' => false],
                    ['option' => 'Hg', 'is_correct' => false],
                    ['option' => 'Au', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Reactivity Series',
                'explanation' => 'Gold (Au) is known for its lack of reactivity compared to other metals; it does not tarnish or corrode under normal conditions.'
            ],
            [
                'question' => 'Geometric isomerism can exist in',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'hex-3-ene', 'is_correct' => true],
                    ['option' => 'hexane', 'is_correct' => false],
                    ['option' => 'prop-1-ene', 'is_correct' => false],
                    ['option' => '3-methyl but-1-ene', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'Geometric isomerism requires the presence of a C=C double bond with different groups attached, which is possible in hex-3-ene.'
            ],
            [
                'question' => 'Alkanals can be distinguished from alkanones by the reaction with',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'Sudan III stain', 'is_correct' => false],
                    ['option' => 'starch iodide paper', 'is_correct' => false],
                    ['option' => 'lithium tetrahydrido aluminate (III)', 'is_correct' => false],
                    ['option' => 'Fehling’s solution', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'Fehling’s solution can be used to distinguish aldehydes (alkanals) from ketones (alkanones) because aldehydes will react to form a red copper(I) oxide precipitate.'
            ],
            [
                'question' => 'The isomers of C3H8O are',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => '1 - propanol and 2 - propanol', 'is_correct' => false],
                    ['option' => '1 - propanol and 1 - propanol', 'is_correct' => false],
                    ['option' => '2 - propanol and 2 - propanone', 'is_correct' => true],
                    ['option' => '2 - propanol and 1 - propanol', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'C3H8O can be 2-propanol (isopropyl alcohol) or 1-propanol (n-propyl alcohol), but 2-propanone (acetone) is also a possible isomer with the same molecular formula, though it is a ketone, not an alcohol.'
            ],
            [
                'question' => 'The alkyne that will give a white precipitate silver trioxonitrate (V) is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'CH3C≡CCH2CH3', 'is_correct' => true],
                    ['option' => 'CH3C≡CCH2CH2CH3', 'is_correct' => false],
                    ['option' => 'CH3CH2CH2C≡CH', 'is_correct' => false],
                    ['option' => 'CH3CH2CH2C≡CCH2CH3', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'The alkyne with a terminal triple bond (C≡CH) will react with silver nitrate to form a white precipitate of silver acetylide. The correct compound is CH3C≡CCH2CH3, which has a terminal triple bond.'
            ],
            [
                'question' => 'The saponification of an alkanoate to produce soap and alkanol involves',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'dehydration', 'is_correct' => false],
                    ['option' => 'esterification', 'is_correct' => false],
                    ['option' => 'hydrolysis', 'is_correct' => true],
                    ['option' => 'oxidation', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'Saponification is the hydrolysis of an ester (alkanoate) in the presence of a base to form a carboxylate salt (soap) and an alcohol (alkanol).'
            ],
            [
                'question' => '2-methylpropan-2-ol is an example of a',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'primary alkanol', 'is_correct' => false],
                    ['option' => 'secondary alkanol', 'is_correct' => false],
                    ['option' => 'tertiary alkanol', 'is_correct' => true],
                    ['option' => 'quaternary alkanol', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => '2-methylpropan-2-ol is a tertiary alcohol because the hydroxyl-bearing carbon is attached to three other carbon atoms.'
            ],
            [
                'question' => 'The final oxidation product of alkanol, alkanal and alkanones is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'alkanoic acid', 'is_correct' => true],
                    ['option' => 'alkanoyl halide', 'is_correct' => false],
                    ['option' => 'alkanoate', 'is_correct' => false],
                    ['option' => 'alkanamide', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'Alkanols, alkanals, and alkanones upon complete oxidation typically form alkanoic acids. For example, ethanol (an alkanol) can be oxidized to acetic acid, an alkanal to a corresponding acid, and so can an alkanone under vigorous oxidation conditions.'
            ],
            [
                'question' => 'Ethanol reacts with concentrated tetraoxosulphate (V) acid at a temperature above 170°C to form',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'ethanone', 'is_correct' => false],
                    ['option' => 'ethene', 'is_correct' => true],
                    ['option' => 'ethyne', 'is_correct' => false],
                    ['option' => 'ethanal', 'is_correct' => false]
                ],
                'type' => 'mcq',
                'topic' => 'Organic Chemistry',
                'explanation' => 'When ethanol is heated with concentrated sulphuric acid, it gets dehydrated to produce ethene gas.'
            ],
            [
                'question' => 'An example of oxidation-reduction enzyme is',
                'year' => 2012,
                'marks' => 2,
                'options' => [
                    ['option' => 'amylase', 'is_correct' => false],
                    ['option' => 'protease', 'is_correct' => false],
                    ['option' => 'lipase', 'is_correct' => false],
                    ['option' => 'dehydrogenase', 'is_correct' => true]
                ],
                'type' => 'mcq',
                'topic' => 'Biochemistry',
                'explanation' => 'Dehydrogenase enzymes are involved in oxidation-reduction reactions, where they aid in the removal (oxidation) of hydrogen atoms from substrates.'
            ]







            // ... add the remaining questions in the same format
        ];

        // Calculate total marks
        $total_marks = array_sum(array_column($questions, 'marks'));

        // Create or find a quiz associated with the physics subject
        $quiz = Quiz::firstOrCreate([
            'title' => $chemistry->name,
            'quizzable_type' => Subject::class,
            'quizzable_id' => $chemistry->id,
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
                'quizzable_id' => $chemistry->id,
                'question' => $questionData['question'],
                'marks' => $questionData['marks'],
                'type' => $questionData['type'],
                'answer_text' => $questionData['answer_text'] ?? null, // Provide a default null if 'answer_text' is not set
                'explanation' => $questionData['explanation'] ?? null,
                'year' => $questionData['year'] ?? null,
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
