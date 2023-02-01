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
        return $this->render('admin/dashboard.html.twig', [
            'post_count' => $this->mediasRepository->count([]),
            'user_count' => $this->usersRepository->count([]),
            'active_category_count' => $this->categoriesRepository->getActiveCategoryCount(),
            'media_by_category' => $this->categoriesRepository->getMediaByCategory(),
            'media_by_user' => $this->usersRepository->getMediaByUser(), 
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
