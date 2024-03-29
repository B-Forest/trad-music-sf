<?php

namespace App\Controller\Admin;

use App\Entity\Gig;
use App\Entity\Instrument;
use App\Entity\Manager;
use App\Entity\Musician;
use App\Entity\Pub;
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
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend

         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(PubCrudController::class)->generateUrl());

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
            ->setTitle('Trad Music Sf');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Pubs', 'fas fa-list', Pub::class);
        yield MenuItem::linkToCrud('Managers', 'fas fa-list', Manager::class);
        yield MenuItem::linkToCrud('Instruments', 'fas fa-list', Instrument::class);
        yield MenuItem::linkToCrud('Gigs', 'fas fa-list', Gig::class);
        yield MenuItem::linkToCrud('Musicians', 'fas fa-list', Musician::class);
        yield MenuItem::linkToRoute('Trad Music', 'fa-solid fa-music', 'homepage');

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
