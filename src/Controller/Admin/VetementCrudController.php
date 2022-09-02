<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Vetement;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VetementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vetement::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Nom');
        yield TextField::new('description', 'Description de l\'article');
        yield ChoiceField::new('size', 'Taille')->renderExpanded()->allowMultipleChoices()->setChoices([
            'small' => 'small',
            'medium' => 'medium',
            'large' => 'large',
        ]);
        yield ChoiceField::new('color', 'Couleur')->allowMultipleChoices()->setChoices([
            'blanc' => 'blanc',
            'noir' => 'noir',
            'rouge' => 'rouge',
        ]);
        yield ImageField::new('photo', 'Photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie');
        yield AssociationField::new('marques', 'Marque de l\'article');
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->hideOnForm();
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Vetement) return;
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
            ->add(EntityFilter::new('categorie'))
            ->add(EntityFilter::new('sousCategorie'))
            ->add(DateTimeFilter::new('createdAt'));
    }
}
