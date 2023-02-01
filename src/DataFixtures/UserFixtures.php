<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setPassword("admin");
        $admin->setEmail("admin@localhost");
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
        ];
    }
}
