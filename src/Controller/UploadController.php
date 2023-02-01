<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepository;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
            
            //Get categories from database
            $categories = $categoriesRepository->findBy(['status' => '1']);
            
            //If no category found, throw an exception
            if (!$categories) {
                throw $this->createNotFoundException(
                    'No category found'
                );
            }
    
            return $this->render('upload/index.html.twig', [
                'categories' => $categories,
            ]);
        
    }
}
