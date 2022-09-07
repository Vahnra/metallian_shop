<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Expedition;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExpeditionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Expedition::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'titre');
        yield TextEditorField::new('description');
        yield TextEditorField::new('LongDescription', 'Description complète');
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
        
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Expedition) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }
   
}
