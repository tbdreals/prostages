<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $formation_DUT_Info = new Formation();
        $formation_DUT_Info->setIntitule("DUT Informatique");
        $formation_DUT_Info->setNiveau("Bac +2");
        $formation_DUT_Info->setVille("Anglet");
        $manager->persist($formation_DUT_Info);

        $manager->flush();
    }
}
