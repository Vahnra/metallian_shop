<?php

namespace App\Controller\Admin;

use App\Entity\Bijoux;
use DateTimeImmutable;
use App\Entity\SousCategorie;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BijouxCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bijoux::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
       
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('title', 'Titre');
        yield TextField::new('description');
        yield TextareaField::new('longDescription', 'Description complète')->setMaxLength(250)->setNumOfRows(7);
        yield MoneyField::new('price', 'prix')->setCurrency('EUR');

        yield FormField::addPanel('Photos de l\'article');
        yield ImageField::new('photo')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo2')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo3')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo4')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo5')->setBasePath('images')->setUploadDir('public/images');

        yield FormField::addPanel('Catégorie de l\'article');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie')->hideOnForm();
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Bijoux) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
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
