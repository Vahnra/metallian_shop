<?php

namespace App\Controller\Admin;

use App\Entity\ReviewVetement;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReviewVetementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReviewVetement::class;
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
