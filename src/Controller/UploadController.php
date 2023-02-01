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
    public function index(Request $request, CategoriesRepository $categoriesRepository, MediasRepository $mediasRepository, UsersRepository $usersRepository): Response
    {
        if ($this->getUser()) {

            //Get categories from database
            $categories = $categoriesRepository->findBy(['status' => '1']);

            //If no category found, throw an exception
            if (!$categories) {
                throw $this->createNotFoundException(
                    'No category found'
                );
            }
            //Get categories from database that are active
            $categories = $categoriesRepository->getActive();
            
            //If no category found, throw an exception
            if (!$categories) {
                throw $this->createNotFoundException(
                    'No category found'
                );
            }

            $media = new Medias();

            $form = $this->createFormBuilder($media)
                ->add('imageFile', VichImageType::class)
                ->add('title', TextType::class)
                ->add('description', TextareaType::class, [
                    'required' => false
                ])
                ->add('category', ChoiceType::class, [
                    'choices'  => $categories,
                    'choice_label' => 'name'
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Upload'
                ])
                ->getForm();

            $form->handleRequest($request);

            $user = new Users();
            $user = $usersRepository->findOneBy(['id' => 3])->getUsers();

            if ($form->isSubmitted() && $form->isValid()) {
                //Handle file upload
                /** @var UploadedFile $file */
                $file = $form['imageFile']->getData();
                $filename = uniqid().'.'.$file->guessExtension();
                $file->move($this->getParameter('media_directory'), $filename);
                $media->setPath($filename);
                $media->setUser($user); # FIX ME: find a way to get the connected user (and not user 3)
                $media->setStatus($categoriesRepository->findOneBy(['id' => 3])->getStatus()); # FIX ME: find a way to get the status by label
                $media->setImageFile(); # removing the reference of previous file preventing an issue
                $mediasRepository->save($media, true);

                return $this->redirectToRoute('homepage');
            }

            return $this->render('upload/index.html.twig', [
                'form' => $form->createView(),
                'categories' => $categories,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
