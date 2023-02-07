<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MediasRepository;

class UserPageController extends AbstractController
{
    #[Route('/u/{id}', name: 'userpage')]
    public function index(MediasRepository $mediasRepository, int $id)
    {
        //Get medias from database that are active and belong to the user
        $medias = $mediasRepository->getActiveByUser($id);
    
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
        
        return $this->render('user_page/index.html.twig', [
            'medias' => $medias,
            'user_id' => $id
        ]);
    }
}
