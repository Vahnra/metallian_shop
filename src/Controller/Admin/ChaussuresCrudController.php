<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Chaussures;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChaussuresCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chaussures::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('titre');
        yield TextField::new('description');
        yield ChoiceField::new('color')->renderExpanded()->allowMultipleChoices()->setChoices([
            'blanc' => 'white',
            'black' => 'black',
        ]);
        yield MoneyField::new('price', 'Prix')->setCurrency('EUR');
        yield ImageField::new('photo')->setBasePath('images')->setUploadDir('public/images');
        yield ChoiceField::new('size' ,'taille')->renderExpanded()->allowMultipleChoices()->setChoices([
            '35' => '35',
            '36' => '36',
            '37' => '37',
            '38' => '38',
        ]);
        yield AssociationField::new('categorie');
        yield AssociationField::new('sousCategorie');
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Chaussures) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }
    
}
