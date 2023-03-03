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
use App\Entity\Products;
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
use App\Entity\OrderReclamation;
use App\Entity\VetementQuantity;
use App\Entity\ChaussuresQuantity;
use App\Entity\ProductsQuantities;
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
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use App\Repository\VetementMerchandisingRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use App\Repository\AccessoiresMerchandisingRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $userRepository = null;
    private $orderRepository = null;
    private $chartBuilder = null;

    public function __construct(
        ChartBuilderInterface $chartBuilder,
        UserRepository $userRepository,
        OrderRepository $orderRepository
        )
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->chartBuilder = $chartBuilder;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $totalRegisteredUser = $this->userRepository->findAll();

        $totalOrders = count($this->orderRepository->findAll());
        
        $totalArticles = 0;

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
        yield MenuItem::subMenu('Gérer les réclamations')->setSubItems([
            MenuItem::linkToCrud('Voir les réclamations', 'fas fa-eye' ,OrderReclamation::class),
            MenuItem::linkToCrud('Ajouter une réclamation', 'fas fa-plus', OrderReclamation::class)->setAction(Crud::PAGE_NEW)
        ]);

        // Article en ventes
        yield MenuItem::section('Articles en ventes');

        yield MenuItem::subMenu('Tous les articles')->setSubItems([
            MenuItem::linkToCrud('Voire les articles en vente', 'fas fa-eye', ProductsQuantities::class)->setController(ArticlesQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un article', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(ArticlesQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Homme')->setSubItems([
            MenuItem::linkToCrud('Voire les articles homme en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un article homme', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Femme')->setSubItems([
            MenuItem::linkToCrud('Voire les articles femme en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementFemmeQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un article femme', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Enfant')->setSubItems([
            MenuItem::linkToCrud('Voire les articles enfant en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementEnfantQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un article enfant', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementEnfantQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voire les accessoires en vente', 'fas fa-eye', ProductsQuantities::class)->setController(AccessoiresQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un accessoire', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Chaussures')->setSubItems([
            MenuItem::linkToCrud('Voire les chaussures en vente', 'fas fa-eye', ProductsQuantities::class)->setController(ChaussuresQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente une chaussure', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(ChaussuresQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Bijoux')->setSubItems([
            MenuItem::linkToCrud('Voire les bijoux en vente', 'fas fa-eye', ProductsQuantities::class)->setController(BijouxQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un bijoux', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(BijouxQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('CDs')->setSubItems([
            MenuItem::linkToCrud('Voire les cds en vente', 'fas fa-eye', ProductsQuantities::class)->setController(MediaQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un cd', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(MediaQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Vinyles')->setSubItems([
            MenuItem::linkToCrud('Voire les vinyles en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VinylesQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un vinyle', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VinylesQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Mechs Homme')->setSubItems([
            MenuItem::linkToCrud('Voire les merchandising homme en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementMerchandisingQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un merchandising homme', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingQuantityCrudController::class)
        ]);
        yield MenuItem::subMenu('Merchs Femme')->setSubItems([
            MenuItem::linkToCrud('Voire les merchandising femme en vente', 'fas fa-eye', ProductsQuantities::class)->setController(VetementFemmeMerchandisingQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en vente un merchandising femme', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingQuantityCrudController::class)
        ]);

        // Catégorie normal
        yield MenuItem::section('Listes des catégories');

        yield MenuItem::subMenu('Catégorie')->setSubItems([
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categorie::class),
            MenuItem::linkToCrud('Créer une catégorie', 'fas fa-plus', Categorie::class)->setAction(Crud::PAGE_NEW)
        ]);

        yield MenuItem::subMenu('Sous catégories')->setSubItems([
            MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorie::class),
            MenuItem::linkToCrud('Créer une sous-catégorie', 'fas fa-plus', SousCategorie::class)->setAction(Crud::PAGE_NEW)
        ]);
        

        yield MenuItem::subMenu('Homme')->setSubItems([
            MenuItem::linkToCrud('Voir les articles homme', 'fas fa-eye', Products::class)->setController(VetementCrudController::class),
            MenuItem::linkToCrud('Ajouter un article homme', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementCrudController::class),
        ]);

        yield MenuItem::subMenu('Femme')->setSubItems([
            MenuItem::linkToCrud('Voir les articles femme', 'fas fa-eye', Products::class)->setController(VetementFemmeCrudController::class),
            MenuItem::linkToCrud('Ajouter un article femme', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeCrudController::class),
        ]);

        yield MenuItem::subMenu('Enfant')->setSubItems([
            MenuItem::linkToCrud('Voir les articles enfant', 'fas fa-eye', Products::class)->setController(VetementEnfantCrudController::class),
            MenuItem::linkToCrud('Ajouter un article enfant', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementEnfantCrudController::class),
        ]);

        yield MenuItem::subMenu('Accessoires')->setSubItems([
            MenuItem::linkToCrud('Voir les accessoires', 'fas fa-eye', Products::class)->setController(AccessoiresCrudController::class),
            MenuItem::linkToCrud('Ajouter un accessoire', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresCrudController::class),
        ]);

        yield MenuItem::subMenu('Chaussures')->setSubItems([
            MenuItem::linkToCrud('Voir les articles chaussures', 'fas fa-eye', Products::class)->setController(ChaussuresCrudController::class),
            MenuItem::linkToCrud('Ajouter un article chaussure', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(ChaussuresCrudController::class),
        ]);

        yield MenuItem::subMenu('Bijoux')->setSubItems([
            MenuItem::linkToCrud('Voir les bijoux', 'fas fa-eye', Products::class)->setController(BijouxCrudController::class),
            MenuItem::linkToCrud('Ajouter des bijoux', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(BijouxCrudController::class),
        ]);

        yield MenuItem::subMenu('CDs')->setSubItems([
            MenuItem::linkToCrud('Voir les articles cds', 'fas fa-eye', Products::class)->setController(MediaCrudController::class),
            MenuItem::linkToCrud('Ajouter un article cd', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(MediaCrudController::class),
        ]);

        yield MenuItem::subMenu('Vinyles')->setSubItems([
            MenuItem::linkToCrud('Voir les articles vinyles', 'fas fa-eye', Products::class)->setController(VinylesCrudController::class),
            MenuItem::linkToCrud('Ajouter un article vinyle', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VinylesCrudController::class),
        ]);

        // Catégories merch
        // yield MenuItem::section('Merchandising');

        // yield MenuItem::subMenu('Catégorie')->setSubItems([
        //     MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', CategorieMerchandising::class),
        //     MenuItem::linkToCrud('Ajouter une catégorie', 'fas fa-plus', CategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        // ]);

        // yield MenuItem::subMenu('Sous-catégorie')->setSubItems([
        //     MenuItem::linkToCrud('Voir les sous-catégories', 'fas fa-eye', SousCategorieMerchandising::class),
        //     MenuItem::linkToCrud('Ajouter une sous-catégorie', 'fas fa-plus', SousCategorieMerchandising::class)->setAction(Crud::PAGE_NEW)
        // ]);

        yield MenuItem::subMenu('Merchs Homme')->setSubItems([
            MenuItem::linkToCrud('Voir tous les articles', 'fas fa-eye', Products::class)->setController(VetementMerchandisingCrudController::class),
            MenuItem::linkToCrud('T-shirt', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingCrudController::class),
            MenuItem::linkToCrud('Sweats', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingSweatsCrudController::class),
            MenuItem::linkToCrud('Shorts', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingShortsCrudController::class),
            MenuItem::linkToCrud('Casquettes', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingCasquettesCrudController::class),
            MenuItem::linkToCrud('Bonnets', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingBonnetsCrudController::class),
            MenuItem::linkToCrud('Mugs', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingMugsCrudController::class),
            MenuItem::linkToCrud('Puzzles', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingPuzzlesCrudController::class),
            MenuItem::linkToCrud('Bijoux', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingBijouxCrudController::class),
            MenuItem::linkToCrud('Maison et Décoration', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingMaisonEtDecorationsCrudController::class),
            MenuItem::linkToCrud('Sacs et Portefeuilles', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingSacsEtPortefeuillesCrudController::class),
            MenuItem::linkToCrud('Patchs', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingPatchsCrudController::class),
            MenuItem::linkToCrud('Dossards', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingDossardsCrudController::class),
            MenuItem::linkToCrud('Objects divers', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementMerchandisingObjetsDiversCrudController::class),
        ]);

        yield MenuItem::subMenu('Merchs Femme')->setSubItems([
            MenuItem::linkToCrud('Voir les articles', 'fas fa-eye', Products::class)->setController(VetementFemmeMerchandisingCrudController::class),
            MenuItem::linkToCrud('Girlies', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingCrudController::class),
            MenuItem::linkToCrud('Sweats', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingSweatsCrudController::class),
            MenuItem::linkToCrud('Pantalons', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingPantalonsCrudController::class),
            MenuItem::linkToCrud('Shorts', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingShortsCrudController::class),
            MenuItem::linkToCrud('Jupes', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingJupesCrudController::class),
            MenuItem::linkToCrud('Robes', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingRobesCrudController::class),
            MenuItem::linkToCrud('Casquettes', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingCasquettesCrudController::class),
            MenuItem::linkToCrud('Bonnets', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingBonnetsCrudController::class),
            MenuItem::linkToCrud('Mugs', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingMugsCrudController::class),
            MenuItem::linkToCrud('Puzzles', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingPuzzlesCrudController::class),
            MenuItem::linkToCrud('Bijoux', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingBijouxCrudController::class),
            MenuItem::linkToCrud('Maison et Décoration', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingMaisonEtDecorationCrudController::class),
            MenuItem::linkToCrud('Sacs et Portefeuilles', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingCrudController::class),
            MenuItem::linkToCrud('Patches', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingPatchesCrudController::class),
            MenuItem::linkToCrud('Dossards', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingDossardsCrudController::class),
            MenuItem::linkToCrud('Objects divers', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(VetementFemmeMerchandisingObjetsDiversCrudController::class),
        ]);

        // yield MenuItem::subMenu('Accessoires')->setSubItems([
        //     MenuItem::linkToCrud('Voir les accessoires', 'fas fa-eye', Products::class)->setController(AccessoiresMerchandisingCrudController::class),
        //     MenuItem::linkToCrud('Ajouter un accessoire', 'fas fa-plus', Products::class)->setAction(Crud::PAGE_NEW)->setController(AccessoiresMerchandisingCrudController::class),
        // ]);

        yield MenuItem::section('Soldes');

        yield MenuItem::subMenu('Articles en solde')->setSubItems([
            MenuItem::linkToCrud('Voire les articles en solde', 'fas fa-eye', ProductsQuantities::class)->setController(SoldesQuantityCrudController::class),
            MenuItem::linkToCrud('Mettre en solde un article', 'fas fa-plus', ProductsQuantities::class)->setAction(Crud::PAGE_NEW)->setController(SoldesQuantityCrudController::class)
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

        // yield MenuItem::subMenu('Les artistes')->setSubItems([
        //     MenuItem::linkToCrud('Voir les artistes', 'fas fa-eye', Artist::class),
        //     MenuItem::linkToCrud('Ajouter un artiste', 'fas fa-plus', Artist::class)->setAction(Crud::PAGE_NEW)
        // ]);

        yield MenuItem::subMenu('Les genres musicaux')->setSubItems([
            MenuItem::linkToCrud('Voir les genres', 'fas fa-eye', MusicType::class),
            MenuItem::linkToCrud('Ajouter un genres', 'fas fa-plus', MusicType::class)->setAction(Crud::PAGE_NEW)
        ]);

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

        
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFirstName())
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
   
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            ->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ;
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

        // $vetements = count($this->vetementRepository->findAll());
        // $accessoires = count($this->accessoiresRepository->findAll());
        // $chaussures = count($this->chaussuresRepository->findAll());
        // $bijoux = count($this->bijouxRepository->findAll());
        // $media = count($this->mediaRepository->findAll());
        // $vetementMerchandising = count($this->vetementMerchandisingRepository->findAll());
        // $accessoiresMerchandising = count($this->accessoiresMerchandisingRepository->findAll());

        $totalArticlesChart->setData([
            'labels' => ['Vêtements', 'Accessoires', 'Chaussures', 'Bijoux', 'Médias', 'Vêtements Merch', 'Accessoires Merch'],
            'datasets' => [
                [
                    'label' => 'Nombres d\'articles',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    // 'data' => [$vetements, $accessoires, $chaussures, $bijoux, $media, $vetementMerchandising, $accessoiresMerchandising],
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
