<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

   
    public function configureFields(string $pageName): iterable
    {
        
        yield IdField::new('id')->hideOnForm();

        yield FormField::addPanel('Première bannière');
        yield ImageField::new('photo1', 'Photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        yield UrlField::new('link', 'Lien');
        yield TextField::new('title1', 'Titre');
        
        yield FormField::addPanel('Deuxième bannière');
        yield ImageField::new('photo2', 'Photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        yield UrlField::new('link2', 'Lien');
        yield TextField::new('title2', 'Titre');

        yield FormField::addPanel('Troisième bannière');
        yield ImageField::new('photo3', 'Photo')->setBasePath('images')->setUploadDir('public/images')->setUploadedFileNamePattern('[contenthash].[extension]')->setRequired(false);
        yield UrlField::new('link3', 'Lien');
        yield TextField::new('title3', 'Titre');
        
        yield DateField::new('createdAt', 'Créez le')->hideOnForm();
        yield DateField::new('updatedAt', 'Modifié le')->hideOnForm();
        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Bannière')
            ->setEntityLabelInPlural('Bannières')
        ;
    }
   
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if(!$entityInstance instanceof Slider) return;
        $entityInstance->setCreatedAt(new DateTimeImmutable);
        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        parent::persistEntity($entityManager, $entityInstance);
    }


}
