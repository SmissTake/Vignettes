<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepository;
use App\Repository\MediasRepository;
use App\Repository\UsersRepository;
use App\Entity\Medias;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

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