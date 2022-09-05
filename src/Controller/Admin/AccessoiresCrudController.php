<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Accessoires;
use App\Entity\SousCategorie;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
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
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccessoiresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accessoires::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('title', 'Titre');
        yield TextField::new('description');
        yield TextareaField::new('longDescription', 'Description complète')->setMaxLength(250)->setNumOfRows(7);
        yield AssociationField::new('color');
        yield AssociationField::new('material');
        yield MoneyField::new('price')->setCurrency('EUR');

        yield FormField::addPanel('Photos de l\'article');
        yield ImageField::new('photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);

        yield FormField::addPanel('Stock');

        yield FormField::addPanel('Catégorie de l\'article');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie')->hideOnForm();
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
    }


    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Accessoires) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }
    
    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('title'))
            ->add(NumericFilter::new('price'))
            ->add(TextFilter::new('taille'))
            ->add(EntityFilter::new('categorie'));
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $formBuilder->get('categorie')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $brande = $event->getForm()->getData();
                $form = $event->getForm();
                $form->getParent()->add('sousCategorie', EntityType::class, [
                    'class' => SousCategorie::class,
                    'placeholder' => '',
                    'choices' => $brande ? $brande->getSousCategories() : [],
                ]);
            }
        );

        $formBuilder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $form->add('sousCategorie', EntityType::class, [
                    'class' => SousCategorie::class,
                    'placeholder' => '',
                    'choices' => [],
                ]);
            }
        );

        return $formBuilder;
    }
}
