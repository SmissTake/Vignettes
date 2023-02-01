<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MediasRepository;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(MediasRepository $mediasRepository)
    {
        //Get medias from database that are active
        $medias = $mediasRepository->getActive();
    
        //If no media found, throw an exception
        if (!$medias) {
            throw $this->createNotFoundException(
                'No media found'
            );
        }

        //Clean the array of any html tags
        foreach ($medias as $media) {
            $media->setTitle(strip_tags($media->getTitle()));
            $media->setDescription(strip_tags($media->getDescription()));
        }

        return $this->render('homepage/index.html.twig', [
            'medias' => $medias,
        ]);
    }
}