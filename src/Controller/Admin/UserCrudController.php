<?php

namespace App\Controller\Admin;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('firstname');
        yield TextField::new('lastname');
        yield TextField::new('email');
        yield TextField::new('password');
        yield TextField::new('gender');
        yield DateField::new('createdAt')->hideOnForm();
        yield DateField::new('updatedAt')->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof User) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }
    
}
