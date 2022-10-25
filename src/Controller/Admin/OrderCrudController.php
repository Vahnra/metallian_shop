<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use DateTimeImmutable;
use App\Entity\OrderProduct;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
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
        
        yield IdField::new('id', 'Commande')->hideOnForm();

        yield FormField::addPanel('Détails de la commande');
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

        yield FormField::addPanel('Article(s) de la commande');
        yield ArrayField::new('orderProducts', 'Articles')->hideOnForm();

        yield FormField::addPanel('Détails du client');
        yield NumberField::new('mobile', 'Numéro de téléphone');
        yield TextField::new('email', 'Email');
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom');
        yield AssociationField::new('user', 'Client');

        yield FormField::addPanel('Adresse');
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom');
        yield TextField::new('adress', 'Adresse');
        yield TextField::new('additionalAdress', 'Complément d\'adresse');
        yield NumberField::new('postCode', 'Code postale');
        yield TextField::new('city', 'Ville');
        yield TextField::new('country', 'Pays');
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
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
