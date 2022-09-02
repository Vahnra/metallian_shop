<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\VetementMerchandising;
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
        ]);;
        yield ImageField::new('photo', 'Photo')->setBasePath('images')->setUploadDir('public/images');
        yield AssociationField::new('categorieMerchandising', 'Catégorie');
        yield AssociationField::new('sousCategorieMerchandising', 'Sous catégorie');
        yield AssociationField::new('marques');
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->hideOnForm();
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');
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
}
