<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Titre de album');
        yield TextField::new('description');
        yield TextField::new('artist');
        yield TextField::new('genre');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie');
        yield DateField::new('dateDeSortie');
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
        yield MoneyField::new('price')->setCurrency('EUR');

    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Media) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        
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
            ->add(DateTimeFilter::new('createdAt'))
            ->add(DateTimeFilter::new('dateDeSortie'));
    }
}
