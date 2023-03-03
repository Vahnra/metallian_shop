<?php

namespace App\Controller\Admin;

use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ColorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Color::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        yield   IdField::new('id')->hideOnForm();
        yield   TextField::new('color', 'Couleur');
        yield   ColorField::new('code', 'Code couleur');
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Couleur')
            ->setEntityLabelInPlural('Couleurs')
            ->setDefaultSort(['color' => 'ASC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('color'));
    }
    
}
