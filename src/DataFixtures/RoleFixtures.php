<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Status();
        $admin->setLabel("ROLE_ADMIN");
        $manager->persist($admin);

        $user = new Status();
        $user->setLabel("ROLE_USER");
        $manager->persist($user);

        $manager->flush();
    }
}