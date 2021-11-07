<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Movies;
use App\Entity\Destacadas;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(MoviesCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            //->setTitle('<img src="http://localhost:4200/assets/image/logo.png">')
            ->setTitle('<b>Admin Gufly</b>')
            //->setFaviconPath('http://localhost:4200/assets/image/logo.svg')
            //->setTranslationDomain('my-custom-domain')
            //->setTextDirection('ltr')
            //->renderContentMaximized()
            //->renderSidebarMinimized()
            ->disableUrlSignatures()
            ->generateRelativeUrls()
            ;
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-film'),

            MenuItem::section('Peliculas'),
            MenuItem::linkToCrud('Movies', 'fas fa-play', Movies::class),
        ];
    }
}
