<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Products;
use App\Form\ImagesFormType;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use App\Entity\CategorieMerchandising;
use Symfony\Component\Form\FormEvents;
use App\Entity\AccessoiresMerchandising;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SousCategorieMerchandising;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccessoiresMerchandisingCrudController extends AbstractCrudController
{
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('entity.type = :accessoireMerchandising')
            ->setParameter('accessoireMerchandising', 'accessoireMerchandising');
    }

    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('title', 'Titre');
        yield TextField::new('description', 'Description');
        yield TextEditorField::new('longDescription', 'Description complète');
        yield AssociationField::new('artist', 'Artiste associé');
        yield AssociationField::new('material', 'Matière de l\'article');
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');

        yield FormField::addPanel('Photos de l\'article');
        // yield ImageField::new('photo', 'Photo 1')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo2', 'Photo 1')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo3', 'Photo 2')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo4', 'Photo 3')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        // yield ImageField::new('photo5', 'Photo 4')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        yield CollectionField::new('images')->setFormTypeOption('by_reference', false)->setEntryType(ImagesFormType::class)->onlyOnForms();
        yield CollectionField::new('images')->setTemplatePath('admin\field\images\images.html.twig')->onlyOnDetail();
   

        yield FormField::addPanel('Catégorie de l\'article');
        yield AssociationField::new('categorieMerchandising', 'Catégorie merchandising');
        yield AssociationField::new('sousCategorieMerchandising', 'Sous-catégorie merchandising')->hideOnForm();
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Modifier le')->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Products) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        $entityInstance->setType('accessoireMerchandising');
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Accessoire merchandising')
            ->setEntityLabelInPlural('Accessoires merchandising')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('title'))
            ->add(EntityFilter::new('material'))
            ->add(NumericFilter::new('price'))
            ->add(EntityFilter::new('categorieMerchandising'))
            ->add(EntityFilter::new('sousCategorieMerchandising'))
            ->add(DateTimeFilter::new('createdAt'))
            ->add(DateTimeFilter::new('updatedAt'));
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $formBuilder->get('categorieMerchandising')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $brande = $event->getForm()->getData();
                $form = $event->getForm();
                $form->getParent()->add('sousCategorieMerchandising', EntityType::class, [
                    'class' => SousCategorieMerchandising::class,
                    'placeholder' => '',
                    'choices' => $brande ? $brande->getSousCategorieMerchandisings() : [],
                ]);
            }
        );

        $formBuilder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $form->add('sousCategorieMerchandising', EntityType::class, [
                    'class' => SousCategorieMerchandising::class,
                    'placeholder' => '',
                    'choices' => [],
                ]);
            }
        );

        return $formBuilder;
    }
}
