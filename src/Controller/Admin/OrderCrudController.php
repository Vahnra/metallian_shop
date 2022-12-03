<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use DateTimeImmutable;
use App\Entity\OrderProduct;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
    
        yield FormField::addTab('Détails de la commande')->collapsible();
        yield IdField::new('id', 'Commande')->hideOnForm();
        yield DateField::new('createdAt', 'Créer le')->hideOnForm();
        yield DateField::new('updatedAt', 'Mis à jour le')->onlyOnDetail();
        yield MoneyField::new('total', 'Prix total')->setCurrency('EUR');
        yield ChoiceField::new('status', 'Status')->setChoices([
            'En attente de paiement' => 'pending',
            'Payé' => 'paid',
            'Remboursé' => 'refunded',
            'Envoyé' => 'sent',
            'Livré' => 'delivered',
        ]);
        yield DateField::new('sentAt', 'Envoyé le');
        yield TextField::new('trackingNumber', 'Numéros de suivi');
        yield TextField::new('trackingLink', 'Lien de suivi');

        yield FormField::addPanel('Article(s) de la commande');
        // yield ArrayField::new('orderProducts', 'Articles')->hideOnForm();
        yield AssociationField::new('orderProducts', 'Articles - Quantité')->setTemplatePath('admin/field/order/detail/order_product.html.twig');

        yield FormField::addTab('Détails du client')->collapsible();
        yield NumberField::new('mobile', 'Numéro de téléphone');
        yield TextField::new('email', 'Email');
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom');
        yield AssociationField::new('user', 'Client');
        yield UrlField::new('invoice', 'Facture');
        yield AssociationField::new('orderReclamations', 'Réclamation')->hideOnForm();

        yield FormField::addTab('Adresse')->collapsible();
        yield TextField::new('firstName', 'Prénom')->hideOnIndex();
        yield TextField::new('lastName', 'Nom')->hideOnIndex();
        yield TextField::new('adress', 'Adresse')->hideOnIndex();
        yield TextField::new('additionalAdress', 'Complément d\'adresse')->hideOnIndex();
        yield NumberField::new('postCode', 'Code postale')->hideOnIndex();
        yield TextField::new('city', 'Ville')->hideOnIndex();
        yield TextField::new('country', 'Pays')->hideOnIndex();
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Order) return;
        // DateTimeImmutable - creat the date in the createdAt 
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        // creat the date
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
        ->add(ChoiceFilter::new('status')->setChoices([
            'En attente de paiement' => 'pending',
            'Payé' => 'paid',
            'Remboursé' => 'refunded',
            'Envoyé' => 'sent',
            'Livré' => 'delivered',
        ]))
        ->add(TextFilter::new('firstName'))
        ->add(TextFilter::new('lastName'))
        ->add(NumericFilter::new('total'))
        ->add(EntityFilter::new('user'))
        ->add(DateTimeFilter::new('createdAt'))
        ->add(DateTimeFilter::new('updatedAt'));
    }
}
