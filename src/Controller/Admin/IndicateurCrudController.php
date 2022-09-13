<?php

namespace App\Controller\Admin;

use App\Entity\Indicateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IndicateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Indicateur::class;
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
