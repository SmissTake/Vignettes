<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Status;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $actif = new Status();
        $actif->setLabel("ACTIF");
        $manager->persist($actif);

        $inactif = new Status();
        $inactif->setLabel("INACTIF");
        $manager->persist($inactif);

        $manager->flush();
    }
}
