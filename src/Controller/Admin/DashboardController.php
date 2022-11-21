<?php

namespace App\Controller\Admin;

use App\Entity\Size;

use App\Entity\User;
use App\Entity\Color;
use App\Entity\Media;
use App\Entity\Order;
use App\Entity\Artist;
use App\Entity\Bijoux;
use App\Entity\Slider;
use App\Entity\Marques;
use App\Entity\Material;
use App\Entity\Vetement;
use App\Entity\Categorie;
use App\Entity\MusicType;
use App\Entity\Chaussures;
use App\Entity\Expedition;
use App\Entity\Accessoires;
use App\Entity\ReviewMedia;
use App\Entity\MediaQuantity;
use App\Entity\SousCategorie;
use App\Entity\BijouxQuantity;
use App\Entity\ReviewVetement;
use App\Entity\VetementQuantity;
use App\Entity\ChaussuresQuantity;
use App\Repository\UserRepository;
use App\Entity\AccessoiresQuantity;
use App\Repository\MediaRepository;
use App\Repository\OrderRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\BijouxRepository;
use App\Entity\VetementMerchandising;
use App\Entity\CategorieMerchandising;
use App\Repository\VetementRepository;
use App\Entity\AccessoiresMerchandising;
use App\Repository\ChaussuresRepository;
use App\Repository\AccessoiresRepository;
use App\Entity\SousCategorieMerchandising;
use App\Controller\Admin\UserCrudController;
use App\Entity\VetementMerchandisingQuantity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AccessoiresMerchandisingQuantity;
use App\Entity\Products;
use App\Entity\ProductsQuantities;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use App\Repository\VetementMerchandisingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use App\Repository\AccessoiresMerchandisingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        ChartBuilderInterface $chartBuilder,
        UserRepository $userRepository,
        VetementRepository $vetementRepository,
        ChaussuresRepository $chaussuresRepository,
        AccessoiresRepository $accessoiresRepository,
        BijouxRepository $bijouxRepository,
        VetementMerchandisingRepository $vetementMerchandisingRepository,
        AccessoiresMerchandisingRepository $accessoiresMerchandisingRepository,
        MediaRepository $mediaRepository,
        OrderRepository $orderRepository
        )
    {
        $this->userRepository = $userRepository;
        $this->vetementRepository = $vetementRepository;
        $this->accessoiresRepository = $accessoiresRepository;
        $this->chaussuresRepository = $chaussuresRepository;
        $this->bijouxRepository = $bijouxRepository;
        $this->vetementMerchandisingRepository = $vetementMerchandisingRepository;
        $this->accessoiresMerchandisingRepository = $accessoiresMerchandisingRepository;
        $this->mediaRepository = $mediaRepository;
        $this->orderRepository = $orderRepository;
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $totalRegisteredUser = $this->userRepository->findAll();

        $vetements = count($this->vetementRepository->findAll());
        $accessoires = count($this->accessoiresRepository->findAll());
        $chaussures = count($this->chaussuresRepository->findAll());
        $bijoux = count($this->bijouxRepository->findAll());
        $vetementMerchandising = count($this->vetementMerchandisingRepository->findAll());
        $accessoiresMerchandising = count($this->accessoiresMerchandisingRepository->findAll());
        $totalOrders = count($this->orderRepository->findAll());
        
        $totalArticles = $vetements + $accessoires + $chaussures + $bijoux + $vetementMerchandising + $accessoiresMerchandising;

        return $this->render('admin/admin_home_page.html.twig', [
            'usersChart' => $this->usersChart(),
            'totalArticlesChart' => $this->totalArticlesChart(),
            'totalRegisteredUser' => count($totalRegisteredUser),
            'totalArticles' => $totalArticles,
            'totalOrderChart' => $this->OrderChart(),
            'totalOrders' => $totalOrders
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Metallian Shop');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retourner sur le site', 'fa fa-home', 'default_home');

        // User
        yield MenuItem::section('Utilisateur');
        yield MenuItem::subMenu('Gérer les utilisateurs')->setSubItems([
            MenuItem::linkToCrud('Voir les utilisateurs', 'fas fa-eye' ,User::class),
            MenuItem::linkToCrud('Ajouter un utilisateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Commandes');
        yield MenuItem::subMenu('Gérer les commandes')->setSubItems([
            MenuItem::linkToCrud('Voir les commandes', 'fas fa-eye' ,Order::class),
            MenuItem::linkToCrud('Ajouter une commande', 'fas fa-plus', Order::class)->setAction(Crud::PAGE_NEW)
        ]);

        // Article en ventes
        yield MenuItem::section('Articles en ventes');

        yield MenuItem::subMenu('Vêtements')->setSubItems([
            MenuItem::linkToCrud('Voire les vêtements en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un vêtement', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voire les accessoires en vente', 'fas fa-eye', ProductsQuantities::class)->setController(AccessoiresQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un accessoire', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Médias')->setSubItems([
            MenuItem::linkToCrud('Voire les médias en vente', 'fas fa-eye', ProductsQuantities::class)->setController(MediaQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un média', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(MediaQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Chaussures')->setSubItems([
            MenuItem::linkToCrud('Voire les chaussures en vente', 'fas fa-eye', ProductsQuantities::class)->setController(ChaussuresQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente une chaussure', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(ChaussuresQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Bijoux')->setSubItems([
            MenuItem::linkToCrud('Voire les bijoux en vente', 'fas fa-eye', ProductsQuantities::class)->setController(BijouxQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un bijoux', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(BijouxQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Vêtements Merch')->setSubItems([
            MenuItem::linkToCrud('Voire les vêtements merchandising en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementMerchandisingQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un vêtement merchandising', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Accesoires Merch')->setSubItems([
            MenuItem::linkToCrud('Voire les accessoires merchandising en vente', 'fas fa-eye', ProductsQuantities::class)->setController(AccessoiresMerchandisingQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un accessoires merchandising', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresMerchandisingQuantityCrudController::class)
        ]);

        // Catégorie normal
        yield MenuItem::section('Catégorie normaux');

        yield MenuItem::subMenu('Catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categorie::class),
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Sous catégories')->setSubItems([
            MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorie::class),
            MenuItem::linkToCrud('Créer une sous-catégorie', 'fas fa-plus', SousCategorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Vêtements')->setSubItems([
            MenuItem::linkToCrud('Voir les vêtements', 'fas fa-eye', Products::class)->setController(VetementCrudController::class),
            MenuItem::linkToCrud('Ajouter un vêtement', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementCrudController::class),
        ]);

        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voir les accessoires', 'fas fa-eye', Products::class)->setController(AccessoiresCrudController::class),
            MenuItem::linkToCrud('Ajouter un accessoire', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresCrudController::class),
        ]);

        yield MenuItem::subMenu('Média')->setSubItems([
            MenuItem::linkToCrud('Voir les média', 'fas fa-eye', Products::class)->setController(MediaCrudController::class),
            MenuItem::linkToCrud('Ajouter un média', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(MediaCrudController::class),
        ]);

        yield MenuItem::subMenu('Chaussures')->setSubItems([
            MenuItem::linkToCrud('Voir les chaussures', 'fas fa-eye', Products::class)->setController(ChaussuresCrudController::class),
            MenuItem::linkToCrud('Ajouter des chaussures', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(ChaussuresCrudController::class),
        ]);

        yield MenuItem::subMenu('Bijoux')->setSubItems([
            MenuItem::linkToCrud('Voir les bijoux', 'fas fa-eye', Products::class)->setController(BijouxCrudController::class),
            MenuItem::linkToCrud('Ajouter des bijoux', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(BijouxCrudController::class),
        ]);

        // Catégories merch
        yield MenuItem::section('Merchandising');

        yield MenuItem::subMenu('Catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', CategorieMerchandising::class),
            MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus', CategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Sous-catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorieMerchandising::class),
            MenuItem::linkToCrud('Ajouter une sous-catégorie', 'fas fa-plus', SousCategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Vêtements')->setSubItems([
            MenuItem::linkToCrud('Voir les vêtements', 'fas fa-eye', Products::class)->setController(VetementMerchandisingCrudController::class),
            MenuItem::linkToCrud('Ajouter un vêtement', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingCrudController::class),
        ]);

        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voir les accessoires', 'fas fa-eye', Products::class)->setController(AccessoiresMerchandisingCrudController::class),
            MenuItem::linkToCrud('Ajouter un accessoire', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresMerchandisingCrudController::class),
        ]);

        yield MenuItem::section('Marques');

        yield MenuItem::subMenu('Les marques')->setSubItems([
            MenuItem::linkToCrud('Voir les marques', 'fas fa-eye', Marques::class),
            MenuItem::linkToCrud('Ajouter une marque', 'fas fa-plus', Marques::class)->setAction(Crud::PAGE_NEW)
        ]);

        // Miscelinous
        yield MenuItem::section('Tailles, couleurs, matières, etc');

        yield MenuItem::subMenu('Les tailles')->setSubItems([
            MenuItem::linkToCrud('Voir les tailles', 'fas fa-eye', Size::class),
            MenuItem::linkToCrud('Ajouter une taille', 'fas fa-plus', Size::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Les couleurs')->setSubItems([
            MenuItem::linkToCrud('Voir les couleurs', 'fas fa-eye', Color::class),
            MenuItem::linkToCrud('Ajouter une couleur', 'fas fa-plus', Color::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Les matières')->setSubItems([
            MenuItem::linkToCrud('Voir les matières', 'fas fa-eye', Material::class),
            MenuItem::linkToCrud('Ajouter une matière', 'fas fa-plus', Material::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Les artistes')->setSubItems([
            MenuItem::linkToCrud('Voir les artistes', 'fas fa-eye', Artist::class),
            MenuItem::linkToCrud('Ajouter un artiste', 'fas fa-plus', Artist::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Les genres musicaux')->setSubItems([
            MenuItem::linkToCrud('Voir les genres', 'fas fa-eye', MusicType::class),
            MenuItem::linkToCrud('Ajouter un genres', 'fas fa-plus', MusicType::class)->setAction(Crud::PAGE_NEW)
        ]);

        // yield MenuItem::section('Les commentaires');

        // yield MenuItem::subMenu('Les commentaires sur les vêtements')->setSubItems([
        //     MenuItem::linkToCrud('Voir les commentaires', 'fas fa-eye', ReviewVetement::class),
        // ]);

        // yield MenuItem::subMenu('Les commentaires sur les médias')->setSubItems([
        //     MenuItem::linkToCrud('Voir les commentaires', 'fas fa-eye', ReviewMedia::class),
        // ]);

        yield MenuItem::section('Politique d\'expédition');
        yield MenuItem::subMenu('Expedition')->setSubItems([
            MenuItem::linkToCrud('Voir le Politique d\'expédition', 'fas fa-eye', Expedition::class),
            MenuItem::linkToCrud('Ajouter un Politique d\'expédition', 'fas fa-plus', Expedition::class)->setAction(Crud::PAGE_NEW)
        ]); 

        yield MenuItem::section('Bannières');
        yield MenuItem::subMenu('Les bannières')->setSubItems([
            MenuItem::linkToCrud('Voir les bannières', 'fas fa-eye', Slider::class),
            MenuItem::linkToCrud('Ajouter une bannière', 'fas fa-plus', Slider::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::section('Soldes');
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
        ->addJsFile('jquery-3.6.1.js')
        ->addJsFile('ajax.js')
        ->addWebpackEncoreEntry('admin');
    }

    public function usersChart(): Chart
    {
        $usersChart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        $january = count($this->userRepository->registeredUserByDate('01-01-2022', '01-02-2022'));
        $february = count($this->userRepository->registeredUserByDate('01-02-2022', '01-03-2022'));
        $march = count($this->userRepository->registeredUserByDate('01-03-2022', '01-04-2022'));
        $april = count($this->userRepository->registeredUserByDate('01-04-2022', '01-05-2022'));
        $may = count($this->userRepository->registeredUserByDate('01-05-2022', '01-06-2022'));
        $june = count($this->userRepository->registeredUserByDate('01-06-2022', '01-07-2022'));
        $july = count($this->userRepository->registeredUserByDate('01-07-2022', '01-08-2022'));
        $august = count($this->userRepository->registeredUserByDate('01-08-2022', '01-09-2022'));
        $september = count($this->userRepository->registeredUserByDate('01-09-2022', '01-10-2022'));
        $october = count($this->userRepository->registeredUserByDate('01-10-2022', '01-11-2022'));
        $november = count($this->userRepository->registeredUserByDate('01-11-2022', '01-12-2022'));
        $december = count($this->userRepository->registeredUserByDate('01-12-2022', '31-12-2022'));

        $usersChart->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Utilisateurs enregistrés par mois',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december],
                ],
            ],
        ]);

        $usersChart->setOptions([
            'scales' => [
                'y' => [
                   'suggestedMin' => 0,
                   'suggestedMax' => 100,
                ],
            ],
        ]);

        return $usersChart;
    }

    public function totalArticlesChart(): Chart
    {
        $totalArticlesChart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $vetements = count($this->vetementRepository->findAll());
        $accessoires = count($this->accessoiresRepository->findAll());
        $chaussures = count($this->chaussuresRepository->findAll());
        $bijoux = count($this->bijouxRepository->findAll());
        $media = count($this->mediaRepository->findAll());
        $vetementMerchandising = count($this->vetementMerchandisingRepository->findAll());
        $accessoiresMerchandising = count($this->accessoiresMerchandisingRepository->findAll());

        $totalArticlesChart->setData([
            'labels' => ['Vêtements', 'Accessoires', 'Chaussures', 'Bijoux', 'Médias', 'Vêtements Merch', 'Accessoires Merch'],
            'datasets' => [
                [
                    'label' => 'Nombres d\'articles',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [$vetements, $accessoires, $chaussures, $bijoux, $media, $vetementMerchandising, $accessoiresMerchandising],
                ],
            ],
        ]);

        $totalArticlesChart->setOptions([
            'scales' => [
                'y' => [
                   'suggestedMin' => 0,
                   'suggestedMax' => 100,
                ],
            ],
        ]);

        return $totalArticlesChart;
    }

    public function orderChart(): Chart
    {
        $totalOrderChart = $this->chartBuilder->createChart(Chart::TYPE_BAR);

        $january = count($this->orderRepository->ordersByDate('01-01-2022', '01-02-2022'));
        $february = count($this->orderRepository->ordersByDate('01-02-2022', '01-03-2022'));
        $march = count($this->orderRepository->ordersByDate('01-03-2022', '01-04-2022'));
        $april = count($this->orderRepository->ordersByDate('01-04-2022', '01-05-2022'));
        $may = count($this->orderRepository->ordersByDate('01-05-2022', '01-06-2022'));
        $june = count($this->orderRepository->ordersByDate('01-06-2022', '01-07-2022'));
        $july = count($this->orderRepository->ordersByDate('01-07-2022', '01-08-2022'));
        $august = count($this->orderRepository->ordersByDate('01-08-2022', '01-09-2022'));
        $september = count($this->orderRepository->ordersByDate('01-09-2022', '01-10-2022'));
        $october = count($this->orderRepository->ordersByDate('01-10-2022', '01-11-2022'));
        $november = count($this->orderRepository->ordersByDate('01-11-2022', '01-12-2022'));
        $december = count($this->orderRepository->ordersByDate('01-12-2022', '31-12-2022'));

        $totalOrderChart->setData([
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'datasets' => [
                [
                    'label' => 'Nombres d\'articles',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december],
                ],
            ],
        ]);

        $totalOrderChart->setOptions([
            'scales' => [
                'y' => [
                   'suggestedMin' => 0,
                   'suggestedMax' => 100,
                ],
            ],
        ]);

        return $totalOrderChart;
    }
}
