<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\VetementMerchandising;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SousCategorieMerchandising;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VetementMerchandisingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VetementMerchandising::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('title', 'Nom de l\'article');
        yield TextField::new('description', 'Description de l\'article');
        yield TextareaField::new('longDescription', 'Description complète')->setMaxLength(250)->setNumOfRows(7);
        yield AssociationField::new('marques', 'Marque de l\'article');
        yield AssociationField::new('color', 'La couleur de l\'article');
        yield AssociationField::new('size', 'La taille de l\'article');
        yield AssociationField::new('material', 'Matière de l\'article');
        yield AssociationField::new('material', 'Matière de l\'article');
        // yield AssociationField::new('material', '1 Matière de l\'article');
        // yield AssociationField::new('material', '2 Matière de l\'article');
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');

        yield FormField::addPanel('Photos de l\'article');
        yield ImageField::new('photo', 'Photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');

        yield FormField::addPanel('Catégorie de l\'article');
        yield AssociationField::new('categorieMerchandising');
        yield AssociationField::new('sousCategorieMerchandising')->hideOnForm();

        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->hideOnForm();
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof VetementMerchandising) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('color'))
            ->add(TextFilter::new('size'))
            ->add(EntityFilter::new('marques'))
            ->add(EntityFilter::new('categorieMerchandising'))
            ->add(EntityFilter::new('sousCategorieMerchandising'))
            ->add(DateTimeFilter::new('createdAt'));
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
