<?php

namespace App\Controller\Admin;

use App\Entity\ChaussuresQuantity;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChaussuresQuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ChaussuresQuantity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Nom de l\'article');
        yield AssociationField::new('chaussures');

        yield FormField::addPanel('Détail de l\'article');
        yield AssociationField::new('color');
        yield AssociationField::new('size');
        yield TextField::new('sku', 'Numéro de série');

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');
        
    }
}