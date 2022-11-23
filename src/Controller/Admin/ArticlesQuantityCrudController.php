<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;
use App\Entity\VetementQuantity;
use App\Entity\ProductsQuantities;
use App\Controller\Admin\VetementCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticlesQuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductsQuantities::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Nom de l\'article');
        yield AssociationField::new('products', 'Vêtement')->setCrudController(ProductsCrudController::class)->autocomplete();

        yield FormField::addPanel('Détail de l\'article');
        yield AssociationField::new('color', 'Couleur');
        yield AssociationField::new('size', 'Taille');
        yield TextField::new('sku', 'Numéro de série');

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');

        yield FormField::addPanel('Soldes');
        yield ChoiceField::new('solde', 'En solde')->renderExpanded()->setChoices([
            'Oui' => 'yes',
        ]);
        yield MoneyField::new('products.price', 'Prix')->hideOnForm()->setCurrency('EUR');
        yield MoneyField::new('discount', 'Prix soldé')->setColumns(3)->setCurrency('EUR');

        yield FormField::addPanel('Photos');
        yield CollectionField::new('products.images', 'Images')->setTemplatePath('admin\field\images\images.html.twig')->onlyOnDetail();

    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article en vente')
            ->setEntityLabelInPlural('Articles en vente')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(EntityFilter::new('products'))
            ->add(EntityFilter::new('color'))
            ->add(EntityFilter::new('size'))
            ->add(TextFilter::new('sku'))
            ->add(ChoiceFilter::new('solde')->setChoices([
                'Oui' => 'yes',
            ]))
            ->add(NumericFilter::new('stock'));
    }
}