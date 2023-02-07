<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Roles;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Roles();
        $admin->setLabel("ROLE_ADMIN");
        $manager->persist($admin);

        $user = new Roles();
        $user->setLabel("ROLE_USER");
        $manager->persist($user);

        $manager->flush();
    }
}