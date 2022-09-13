<?php

namespace App\Controller\Admin;

use App\Entity\Periodicite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PeriodiciteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Periodicite::class;
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
