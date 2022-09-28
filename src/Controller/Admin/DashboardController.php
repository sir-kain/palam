<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use App\Entity\Commune;
use App\Entity\Composant;
use App\Entity\Departement;
use App\Entity\Indicateur;
use App\Entity\Periodicite;
use App\Entity\Region;
use App\Entity\Responsable;
use App\Entity\TypeIndicateur;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(ComposantCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Palam');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        return [
            // MenuItem::linkToDashboard('Dashboard', 'home'),

            // MenuItem::section('Planification'),
            MenuItem::linkToDashboard('Statistiques', 'shopping-cart'),
            MenuItem::linkToCrud('Composants', 'home', Composant::class),
            MenuItem::linkToCrud('Activités', 'list', Activite::class),

            // MenuItem::section('Indicateurs'),
            MenuItem::linkToCrud('Indicateurs', 'shopping-cart', Indicateur::class),

            MenuItem::subMenu('Administration', 'map')->setSubItems([
                MenuItem::linkToCrud('Utilisateurs', 'user', User::class),
                MenuItem::linkToCrud('Type indicateurs', 'book', TypeIndicateur::class),
                MenuItem::linkToCrud('Responsables', 'user', Responsable::class),
                MenuItem::linkToCrud('Periodicités', 'package', Periodicite::class),
                MenuItem::linkToCrud('Regions', 'map', Region::class),
                MenuItem::linkToCrud('Departements', 'map', Departement::class),
                MenuItem::linkToCrud('Communes', 'list', Commune::class),
            ])->setPermission('ROLE_ADMIN'),
        ];
    }
}
