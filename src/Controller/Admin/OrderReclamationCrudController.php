<?php

namespace App\Controller\Admin;

use App\Entity\OrderReclamation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderReclamationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderReclamation::class;
    }

    public function configureFields(string $pageName): iterable
    {
       
        yield IdField::new('id', 'Réclamation')->hideOnForm();
        yield AssociationField::new('user', 'Client');
        yield AssociationField::new('orderNumber', 'Commande');
        yield TextField::new('type', 'Type');
        yield TextField::new('message', 'Message');
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
     
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Réclamation')
            ->setEntityLabelInPlural('Réclamations')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }
}
