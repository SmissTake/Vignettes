<?php

namespace App\DataFixtures;

use App\Repository\StatusRepository;
use App\Repository\CategoriesRepository;
use App\Repository\UsersRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Medias;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{    
    public $statusRepository;
    public $categoryRepository;
    public $userRepository;

    public function __construct(StatusRepository $repository, CategoriesRepository $categoryRepository, UsersRepository $userRepository){
        $this->statusRepository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $media = new Medias();
        $media->setTitle("Initial media");
        $media->setDescription("Initial media description");
        $media->setUser($this->userRepository->findOneBy(['email' => 'admin@localhost']));
        $media->setCategory($this->categoryRepository->findOneBy(['name' => 'Dessin']));
        $media->setStatus($this->statusRepository->findOneBy(['label' => 'ACTIF']));
        $media->setPath("ninja.jpg");
        
        $manager->persist($media);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            StatusFixtures::class,
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
