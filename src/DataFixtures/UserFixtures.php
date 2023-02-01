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
        $admin->setPassword('$2y$10$LwyhDnThgFpykvf8Lwx53Oh2BJqe/A72mw6VJc.PxqFIW0Q6Bw2Bu'); # password : admin
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
