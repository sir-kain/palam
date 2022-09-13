<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ActiviteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activite::class;
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
