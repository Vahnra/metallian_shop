<?php

namespace App\Controller\Admin;

use App\Entity\MediaQuantity;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaQuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MediaQuantity::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Nom de l\'article');
        yield AssociationField::new('media', 'Médias');

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('sku', 'Numéro de série');

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Média en vente')
            ->setEntityLabelInPlural('Médias en vente')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(EntityFilter::new('media'))
            ->add(TextFilter::new('sku'))
            ->add(TextFilter::new('stock'));
    }
}
