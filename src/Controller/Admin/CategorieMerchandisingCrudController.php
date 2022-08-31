<?php

namespace App\Controller\Admin;

use App\Entity\CategorieMerchandising;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategorieMerchandisingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CategorieMerchandising::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('title', 'Titre');
    }
}
