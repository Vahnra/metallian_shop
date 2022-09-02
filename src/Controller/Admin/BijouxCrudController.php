<?php

namespace App\Controller\Admin;

use App\Entity\Bijoux;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
        yield TextField::new('title', 'Titre');
        yield TextField::new('description');
        yield MoneyField::new('price', 'prix')->setCurrency('EUR');
        yield ChoiceField::new('color', 'Couleur')->renderExpanded()->allowMultipleChoices()->setChoices([
            'gold' => 'or',
            'silver' => 'argent',
            'black' => 'noir',
        ]);
        yield ImageField::new('photo')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo2')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo3')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo4')->setBasePath('images')->setUploadDir('public/images');
        yield ImageField::new('photo5')->setBasePath('images')->setUploadDir('public/images');
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie');
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
   
}
