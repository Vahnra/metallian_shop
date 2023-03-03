<?php

namespace App\Controller\Admin;

use App\Entity\Marques;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MarquesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Marques::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Nom');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques')
            ->setDefaultSort(['title' => 'ASC'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('title'));
    }
}
