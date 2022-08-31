<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Controller\Admin\UserCrudController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

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
            ->setTitle('Metallian Shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Accueil', 'fa fa-home', 'default_home');
        

        yield MenuItem::section('Utilisateur');
        yield MenuItem::subMenu('Action')->setSubItems([
            MenuItem::linkToCrud('Voir l\'utilisateur', 'fas fa-eye' ,User::class),
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Catégorie');
        yield MenuItem::subMenu('Action')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categorie::class),
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Sous Catégorie');
        yield MenuItem::subMenu('Action')->setSubItems([
            MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorie::class),
            MenuItem::linkToCrud('Créer une sous-catégorie', 'fas fa-plus', SousCategorie::class)->setAction(Crud::PAGE_NEW)
        ]);
     
        yield MenuItem::linkToLogout('Logout', 'fa fa-sign-out');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
}
