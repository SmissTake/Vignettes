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
        if ($this->getUser()) {
            // return $this->redirectToRoute('app_upload');

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
        else{
            // si user pas coo
            return $this->redirectToRoute('app_login');
        }
    }
}
