<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categories;
use App\Entity\Medias;
use App\Entity\Users;
use App\Entity\Roles;
use App\Entity\Status;
use App\Repository\MediasRepository;
use App\Repository\UsersRepository;
use App\Repository\CategoriesRepository;

class DashboardController extends AbstractDashboardController
{
    private $mediasRepository;
    private $usersRepository;
    private $categoriesRepository;

    public function __construct(MediasRepository $mediasRepository, UsersRepository $usersRepository, CategoriesRepository $categoriesRepository)
    {
        $this->mediasRepository = $mediasRepository;
        $this->usersRepository = $usersRepository;
        $this->categoriesRepository = $categoriesRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->getData();
    }

    // get number of media
    public function getMediaCount()
    {
        $media_count = $this->mediasRepository->count([]);
        return $media_count;
    }

    //get number of user
    public function getUserCount()
    {
        $user_count = $this->usersRepository->count([]);
        return $user_count;
    }

    //get number of active categories
    public function getActiveCategoryCount()
    {
        $active_category_count = $this->categoriesRepository->count(['status' => '1']);
        return $active_category_count;
    }

    //get list of categories(name and id) ordered by number of media
    public function getMediaByCategory()
    {
        $query = $this->categoriesRepository
        ->createQueryBuilder('c')
        ->select('c.id, c.name, s.label, COUNT(m) as media_count')
        ->leftJoin(Medias::class, 'm', 'WITH', 'm.category = c.id')
        ->leftJoin(Status::class, 's', 'WITH', 'c.status = s.id')
        ->groupBy('c.id, c.name, s.label')
        ->orderBy('media_count', 'DESC')
        ->setMaxResults(6)
        ->getQuery();
    
        $media_by_category = $query->getResult();
        return $media_by_category;
    }

        //get list of user(mail and id) ordered by number of media
        public function getMediaByUser()
        {
            $query = $this->usersRepository
            ->createQueryBuilder('u')
            ->select('u.id, u.email, COUNT(m) as media_count')
            ->leftJoin(Medias::class, 'm', 'WITH', 'm.user = u.id')
            ->groupBy('u.id, u.email')
            ->orderBy('media_count', 'DESC')
            ->setMaxResults(6)
            ->getQuery();
        
            $media_by_user = $query->getResult();
            return $media_by_user;
        }

    public function getData(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'post_count' => $this->getMediaCount(),
            'user_count' => $this->getUserCount(),
            'active_category_count' => $this->getActiveCategoryCount(),
            'media_by_category' => $this->getMediaByCategory(),
            'media_by_user' => $this->getMediaByUser(), 
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('blossom');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categories::class);
        yield MenuItem::linkToCrud('Medias', 'fas fa-list', Medias::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-list', Users::class);
        yield MenuItem::linkToCrud('Roles', 'fas fa-list', Roles::class);
        yield MenuItem::linkToCrud('Status', 'fas fa-list', Status::class);
    }
}
