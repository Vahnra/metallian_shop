<?php

namespace App\Controller\Admin;

use App\Entity\AccessoiresQuantity;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccessoiresQuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AccessoiresQuantity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Nom de l\'article');
        yield AssociationField::new('accessoires');

        yield FormField::addPanel('Détail de l\'article');
        yield AssociationField::new('color');
        yield AssociationField::new('size');

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');
   
    }
    
}
