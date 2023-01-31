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
        //Get categories from database that are active
        $query = $categoriesRepository->createQueryBuilder('c')
            ->join('c.status', 's')
            ->where('s.label = :label')
            ->setParameter('label', 'actif')
            ->getQuery();
        $categories = $query->getResult();
        
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
