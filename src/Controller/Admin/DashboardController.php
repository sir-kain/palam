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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ActiviteCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Palam');
    }

    public function configureMenuItems(): iterable
    {
        // yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        return [
            // MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

            MenuItem::section('Planification'),
            MenuItem::linkToCrud('Composants', 'fa fa-tags', Composant::class),
            MenuItem::linkToCrud('Activités', 'fa fa-tags', Activite::class),

            MenuItem::section('Indicateurs'),
            MenuItem::linkToCrud('Indicateurs', 'fa fa-tags', Indicateur::class),
            
            MenuItem::section('Administration'),
            // MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
            MenuItem::linkToCrud('Type indicateurs', 'fa fa-file-text', TypeIndicateur::class),
            MenuItem::linkToCrud('Responsables', 'fa-regular fa-clipboard', Responsable::class),
            MenuItem::linkToCrud('Periodicités', 'fa-solid fa-globe', Periodicite::class),
            MenuItem::linkToCrud('Regions', 'fa-regular fa-address-card', Region::class),
            MenuItem::linkToCrud('Departements', 'fa fa-comment', Departement::class),
            MenuItem::linkToCrud('Communes', 'fa fa-comment', Commune::class),
        ];

    }
}
