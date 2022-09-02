<?php

namespace App\Controller\Admin;

use App\Entity\User;

use App\Entity\Accessoires;
use App\Entity\Bijoux;
use App\Entity\Chaussures;
use App\Entity\Media;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\VetementMerchandising;
use App\Entity\CategorieMerchandising;
use App\Entity\AccessoiresMerchandising;
use App\Entity\SousCategorieMerchandising;
use App\Controller\Admin\UserCrudController;
use App\Entity\Marques;
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
        yield MenuItem::linkToRoute('Retourner sur le site', 'fa fa-home', 'default_home');
        

        yield MenuItem::section('Utilisateur');
        yield MenuItem::subMenu('Action')->setSubItems([
            MenuItem::linkToCrud('Voir l\'utilisateur', 'fas fa-eye' ,User::class),
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Catégorie normaux');

        yield MenuItem::subMenu('Catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categorie::class),
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Sous catégories')->setSubItems([
            MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorie::class),
            MenuItem::linkToCrud('Créer une sous-catégorie', 'fas fa-plus', SousCategorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Vetements')->setSubItems([
            MenuItem::linkToCrud('Voir les vetements', 'fas fa-eye', Vetement::class),
            MenuItem::linkToCrud('Ajouter un vetement', 'fas fa-plus', Vetement::class)->setAction(Crud::PAGE_NEW)
        ]);
        
        yield MenuItem::subMenu('Media')->setSubItems([
            MenuItem::linkToCrud('Voir les Media', 'fas fa-eye', Media::class),
            MenuItem::linkToCrud('Ajouter un media', 'fas fa-plus', Media::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voir les accessoires', 'fas fa-eye', Accessoires::class),
            MenuItem::linkToCrud('Ajouter un accessoire', 'fas fa-plus', Accessoires::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Chaussures')->setSubItems([
            MenuItem::linkToCrud('Voir les Chaussures', 'fas fa-eye', Chaussures::class),
            MenuItem::linkToCrud('Ajouter des chaussures', 'fas fa-plus', Chaussures::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Bijoux')->setSubItems([
            MenuItem::linkToCrud('Voir les Bijoux', 'fas fa-eye', Bijoux::class),
            MenuItem::linkToCrud('Ajouter des Bijoux', 'fas fa-plus', Bijoux::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Merchandising');

        yield MenuItem::subMenu('Catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', CategorieMerchandising::class),
            MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus', CategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Sous catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les sous catégories', 'fas fa-eye', SousCategorieMerchandising::class),
            MenuItem::linkToCrud('Ajouter une sous catégorie', 'fas fa-plus', SousCategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Vetements')->setSubItems([
            MenuItem::linkToCrud('Voir les vetements', 'fas fa-eye', VetementMerchandising::class),
            MenuItem::linkToCrud('Ajouter un vetement', 'fas fa-plus', VetementMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Accesoires')->setSubItems([
            MenuItem::linkToCrud('Voir les accesoires', 'fas fa-eye', AccessoiresMerchandising::class),
            MenuItem::linkToCrud('Ajouter un accesoire', 'fas fa-plus', AccessoiresMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Marques');

        yield MenuItem::subMenu('Les marques')->setSubItems([
            MenuItem::linkToCrud('Voir les marques', 'fas fa-eye', Marques::class),
            MenuItem::linkToCrud('Ajouter une marque', 'fas fa-plus', Marques::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Soldes');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
}
