<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categories;
use App\Repository\StatusRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public $statusRepository;

    public function __construct(StatusRepository $repository){
        $this->statusRepository = $repository;
    }

    public function load(ObjectManager $manager): void
    {
        $categories = ['Dessin', 'Photo', 'Motion Design', 'Branding', 'Peinture', 'Webdesign', 'Developpement', 'Autres'];

        foreach ($categories as $categoryName) {
            $category = new Categories();
            $category->setName($categoryName);
            $category->setStatus($this->statusRepository->findOneBy(['label' => 'ACTIF']));

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StatusFixtures::class,
        ];
    }
}
