<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        /*******************************
        *** CREATION DES ENTREPRISES ***
        *******************************/
        $total = new Entreprise ();
        $total -> setNom("Total");
        $total -> setAdresse("10 bis rue des Cervoises, 64000 PAU");
        $total -> setSiteWeb("https://www.total.fr");

        $safran = new Entreprise ();
        $safran -> setNom("Safran");
        $safran -> setAdresse("1632 avenue de l'Amiral Landrin, 64000 PAU");
        $safran -> setSiteWeb("https://www.safran.com");

        $ArcadeAndCo = new Entreprise ();
        $ArcadeAndCo -> setNom("ArcadeAndCo");
        $ArcadeAndCo -> setAdresse("2 allée du Parc Montaury, 64600 ANGLET");
        $ArcadeAndCo -> setSiteWeb("https://www.arcadeandco.fr");

        $tableauEntreprises = array($total, $safran, $ArcadeAndCo);

        foreach ($tableauEntreprises as $entreprise) {
          $manager -> persist($entreprise);
        }


        /****************************************************
        *** CREATION DES FORMATIONS ET DE STAGES ASSOCIES ***
        ****************************************************/
        $nbFormations = 10;

        for ($i=1; $i < $nbFormations; $i++) {
          $formation = new Formation();
          $formation->setIntitule($faker->sentence($nbWords = 3, $variableNbWords = true));
          $formation->setNiveau($faker->regexify('Bac \+'.'[1-8]'));
          $formation->setVille($faker->city());
          $manager->persist($formation);

          $nbStagesAGenerer = $faker -> numberBetween($min = 0, $max = 7);
          for ($numStage = 0; $numStage < $nbStagesAGenerer; $numStage++) {
            $stage = new Stage();
            $stage -> setIntitule($faker -> sentence($nbWords = 3, $variableNbWords = true));
            $stage -> setDescription($faker -> realText($MaxNbChars = 200, $indexSize = 2));

            $stage -> setDateDebut($faker -> dateTimeBetween ($startDate = 'now', $endDate = '+6 months', $timezone = 'Europe/Paris'));
            $stage -> setDuree($faker -> numberBetween($min = 30, $max = 180));
            $stage -> setCompetenceRequise($faker -> realText($MaxNbChars = 100, $indexSize = 2));
            $stage -> setEmailEntreprise($faker -> email());

            $stage -> addFormation($formation);

            $numEntreprise = $faker -> numberBetween($min = 0, $max = 2);
            $stage -> setEntreprise($tableauEntreprises[$numEntreprise]);

            $tableauEntreprises[$numEntreprise] -> addStage($stage);

            $manager -> persist($stage);
            $manager -> persist($tableauEntreprises[$numEntreprise]);
          }
        }

        $manager->flush();
    }
}
