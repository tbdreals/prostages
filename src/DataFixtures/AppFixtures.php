<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        $nbFormations = 10;

        for ($i=1; $i < $nbFormations; $i++) {
          $formation = new Formation();
          $formation->setIntitule($faker->realText($maxNbChars = 20, $indexSize = 2));
          $formation->setNiveau($faker->regexify('Bac \+'.'[1-8]'));
          $formation->setVille($faker->city());
          $manager->persist($formation);
        }

        $manager->flush();
    }
}
