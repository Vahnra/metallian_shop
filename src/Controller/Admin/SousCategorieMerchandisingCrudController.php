<?php

namespace App\Controller\Admin;

use App\Entity\SousCategorieMerchandising;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SousCategorieMerchandisingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SousCategorieMerchandising::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Titre');
        yield AssociationField::new('categorieMerchandising', 'Catégorie merchandising')->setRequired(true);
        yield ChoiceField::new('position')->setChoices([
            'Gauche' => 'left',
            'Droite' => 'right',
        ]);

    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(TextFilter::new('title'))
            ->add(EntityFilter::new('categorieMerchandising'));
    }
}
