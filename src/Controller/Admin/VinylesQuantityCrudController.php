<?php

namespace App\Controller\Admin;

use App\Entity\MediaQuantity;
use Doctrine\ORM\QueryBuilder;
use App\Entity\ProductsQuantities;
use App\Controller\Admin\MediaCrudController;
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
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VinylesQuantityCrudController extends AbstractCrudController
{
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->leftJoin('entity.products', 'vqcs')
            ->andWhere('vqcs.type = :vinyles')
            ->setParameter('vinyles', 'vinyles');
    }
    
    public static function getEntityFqcn(): string
    {
        return ProductsQuantities::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Nom de l\'article');
        yield TextField::new('products.artist', 'Artist')->hideOnForm();
        yield AssociationField::new('products', 'Vinyles')->setCrudController(VinylesCrudController::class)->autocomplete()->hideOnDetail();
        yield TextField::new('products.title', 'Vinyles')->onlyOnDetail();

        yield FormField::addPanel('Détail de l\'article');
        yield TextField::new('sku', 'Numéro de série');

        yield FormField::addPanel('Stock');
        yield NumberField::new('stock', 'Nombre en stock');

        yield FormField::addPanel('Soldes');
        yield ChoiceField::new('solde', 'Mettre en solde ?')->renderExpanded()->setChoices([
            'Oui' => 'yes',
        ]);
        yield MoneyField::new('products.price', 'Prix')->hideOnForm()->setCurrency('EUR');
        yield MoneyField::new('discount', 'Prix soldé')->setColumns(3)->setCurrency('EUR');

        yield FormField::addPanel('Photos')->onlyOnDetail();
        yield CollectionField::new('products.images', 'Images')->setTemplatePath('admin\field\images\images.html.twig')->onlyOnDetail();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Vinyle en vente')
            ->setEntityLabelInPlural('Vinyles en vente')
            ->setDefaultSort(['products.artist' => 'ASC'])
            ->setSearchFields(['products.title', 'sku'])
            ->setPaginatorPageSize(35)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add(EntityFilter::new('products'))
            ->add(TextFilter::new('sku'))
            ->add(TextFilter::new('stock'));
    }
}
