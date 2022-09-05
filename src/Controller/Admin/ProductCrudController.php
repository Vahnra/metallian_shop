<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Nom');
        yield TextField::new('description', 'Description de l\'article');
        yield TextField::new('descriptionLong', 'Description longue de l\'article');
        yield AssociationField::new('category');
        yield AssociationField::new('sousCategorie');
        yield AssociationField::new('productType');
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->hideOnForm();
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Product) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }
}
