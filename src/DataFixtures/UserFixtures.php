<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Users;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UsersFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setUsername("admin");
        $admin->setPassword("admin");
        $admin->setEmail("admin@localhost");
        $admin->setRoles("ROLE_ADMIN");
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}