<?php

namespace App\Controller\Admin;

use App\Entity\TypeIndicateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeIndicateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeIndicateur::class;
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
