<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use DateTimeImmutable;
use App\Entity\Products;
use App\Entity\Categorie;
use App\Form\ImagesFormType;
use App\Entity\SousCategorie;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VinylesCrudController extends AbstractCrudController
{
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('entity.type = :vinyles')
            ->setParameter('vinyles', 'Vinyles');
    }
    
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('artist', 'Nom de l\'artiste');
        yield TextField::new('title', 'Titre de album');
        // yield TextField::new('description');
        yield TextEditorField::new('longDescription', 'Description complète');
        yield AssociationField::new('genre', 'Genre musical')->setQueryBuilder(function (QueryBuilder $qb) {
            $qb->orderBy('entity.genre', 'ASC');
        });;
        yield TextField::new('releaseDate')->setRequired(false);
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');

        yield FormField::addPanel('Photos de l\'article');
        // yield ImageField::new('photo', 'Photo 1')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo2', 'Photo 2')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo3', 'Photo 3')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo4', 'Photo 4')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        yield CollectionField::new('images')->setFormTypeOption('by_reference', false)->setEntryType(ImagesFormType::class)->onlyOnForms();
        yield CollectionField::new('images')->setTemplatePath('admin\field\images\images.html.twig')->onlyOnDetail();

        // yield FormField::addPanel('Catégorie de l\'article');
        // yield AssociationField::new('categorie', 'Catégorie');
        // yield AssociationField::new('sousCategorie', 'Sous-catégorie')->hideOnForm();

        yield FormField::addPanel('Mettre en vente directement ?')->onlyOnForms();
        yield CollectionField::new('productsQuantities', 'Remplir le formulaire')->useEntryCrudForm(VinylesQuantityNestedCrudController::class)->setRequired(false)->onlyOnForms();

        yield DateField::new('createdAt', 'Créé le')->hideOnForm();
        yield DateField::new('updatedAt', 'Modifié le')->hideOnForm();
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vinyle')
            ->setEntityLabelInPlural('Vinyles')
            ->setDefaultSort(['artist' => 'ASC'])
        ;
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Products) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $entityInstance->setType('vinyles');
        $entityInstance->setCategorie($entityManager->getRepository(Categorie::class)->findOneBy(['title' => 'Vinyles']));
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('artist'))
            ->add(TextFilter::new('genre'))
            ->add(EntityFilter::new('categorie'))
            ->add(EntityFilter::new('sousCategorie'))
            ->add(DateTimeFilter::new('createdAt'));
    }

    // public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface 
    // {
    //     $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

    //     $formBuilder->get('categorie')->addEventListener(
    //         FormEvents::POST_SUBMIT,
    //         function (FormEvent $event) {
    //             $brande = $event->getForm()->getData();
    //             $form = $event->getForm();
    //             $form->getParent()->add('sousCategorie', EntityType::class, [
    //                 'class' => SousCategorie::class,
    //                 'placeholder' => '',
    //                 'choices' => $brande ? $brande->getSousCategories() : [],
    //             ]);
    //         }
    //     );

    //     $formBuilder->addEventListener(
    //         FormEvents::POST_SET_DATA,
    //         function (FormEvent $event) {
    //             $form = $event->getForm();
    //             $form->add('sousCategorie', EntityType::class, [
    //                 'class' => SousCategorie::class,
    //                 'placeholder' => '',
    //                 'choices' => [],
    //             ]);
    //         }
    //     );

    //     return $formBuilder;
    // }
}