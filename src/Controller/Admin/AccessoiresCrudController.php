<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Accessoires;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class AccessoiresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accessoires::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Titre');
        yield TextField::new('description');
        yield TextareaField::new('textLong', 'Description compléte')->setMaxLength(250)->setNumOfRows(7);
        yield MoneyField::new('price')->setCurrency('EUR');
        yield ImageField::new('photo')->setBasePath('images')->setUploadDir('public/images');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie');
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
}
