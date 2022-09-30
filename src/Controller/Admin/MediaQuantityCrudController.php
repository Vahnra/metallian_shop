<?php

namespace App\Controller\Admin;

use App\Entity\MediaQuantity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaQuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MediaQuantity::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
