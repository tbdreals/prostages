<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Création de 2 utilisateurs de test

        // Identifiant : tanguy@gmail.com
        // Mot de passe : tanguy
        $tanguy = new User();
        $tanguy->setEmail('tanguy@gmail.com');
        $tanguy->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $tanguy->setPassword('$2y$10$sDFAJ56Rn4nB4QoCuXsyjODO7VR5A99DHyHY8fk2Lyk7ucbVhfBQe');
        $manager->persist($tanguy);

        // Identifiant : antoine@gmail.com
        // Mot de passe : antoine
        $antoine = new User();
        $antoine->setEmail('antoine@gmail.com');
        $antoine->setRoles(['ROLE_USER']);
        $antoine->setPassword('$2y$10$JviqSGEczrS2kIVdd5cDPeq/l7rpUNsfoOBRkSJFb2bpA33YpNI42');
        $manager->persist($antoine);

        // On va utiliser l'outil faker afin de générer du contenu
        $faker = \Faker\Factory::create('fr_FR');

        /*******************************
        *** CREATION DES ENTREPRISES ***
        *******************************/
        // Les entreprises sont créées manuellement
        $total = new Entreprise ();
        $total -> setNom("Total");
        $total -> setAdresse("10 bis rue des Cervoises, 64000 PAU");
        $total -> setSiteWeb("https://www.total.fr");
        $total -> setActivite("Production de pétrole.");

        $safran = new Entreprise ();
        $safran -> setNom("Safran");
        $safran -> setAdresse("1632 avenue de l'Amiral Landrin, 64000 PAU");
        $safran -> setSiteWeb("https://www.safran.com");
        $safran -> setActivite("Production d'épices.");

        $ArcadeAndCo = new Entreprise ();
        $ArcadeAndCo -> setNom("ArcadeAndCo");
        $ArcadeAndCo -> setAdresse("2 allée du Parc Montaury, 64600 ANGLET");
        $ArcadeAndCo -> setSiteWeb("https://www.arcadeandco.fr");
        $ArcadeAndCo -> setActivite("Fabrication de bornes d'arcade.");

        // On stocke les entreprises dans un tableau
        $tableauEntreprises = array($total, $safran, $ArcadeAndCo);

        // on applique la méthode persist à chaque élément du tableau
        foreach ($tableauEntreprises as $entreprise) {
          $manager -> persist($entreprise);
        }


        /****************************************************
        *** CREATION DES FORMATIONS ET DE STAGES ASSOCIES ***
        ****************************************************/
        // Le nombre de formations désirées
        $nbFormations = 10;

        // Les formations sont générées automatiquement
        for ($i=1; $i < $nbFormations; $i++) {
          // On commence par renseigner les caractéristiques de la formation
          $formation = new Formation();
          $formation->setIntitule($faker->sentence($nbWords = 3, $variableNbWords = true));
          $formation->setNiveau($faker->regexify('Bac \+'.'[1-8]'));
          $formation->setVille($faker->city());
          $manager->persist($formation);

          // On génère un nombre aléatoire de stages à générer pour chaque formation
          $nbStagesAGenerer = $faker -> numberBetween($min = 0, $max = 7);

          // Puis on génère automatiquement chacun de ses stages
          for ($numStage = 0; $numStage < $nbStagesAGenerer; $numStage++) {
            // En remplissant ses caractéristiques
            $stage = new Stage();
            $stage -> setIntitule($faker -> jobTitle());
            $stage -> setDescription($faker -> realText($MaxNbChars = 200, $indexSize = 2));
            $stage -> setDateDebut($faker -> dateTimeBetween ($startDate = 'now', $endDate = '+6 months', $timezone = 'Europe/Paris'));
            $stage -> setDuree($faker -> numberBetween($min = 30, $max = 180));
            $stage -> setCompetenceRequise($faker -> realText($MaxNbChars = 100, $indexSize = 2));
            $stage -> setEmailEntreprise($faker -> email());

            // On ajoute le stage à la formation
            $stage -> addFormation($formation);

            // On génère un nombre aléatoire afin de choisir quelle entreprise proposera ce stage
            $numEntreprise = $faker -> numberBetween($min = 0, $max = 2);

            // On ajoute l'entreprise choisie au stage
            $stage -> setEntreprise($tableauEntreprises[$numEntreprise]);

            // On ajoute le stage à l'entreprise choisie
            $tableauEntreprises[$numEntreprise] -> addStage($stage);

            $manager -> persist($stage);
            $manager -> persist($tableauEntreprises[$numEntreprise]);
          }
        }
        $manager->flush();
    }
}
