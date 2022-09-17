<?php

namespace App\Controller\Admin;

use App\Entity\TypeIndicateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TypeIndicateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TypeIndicateur::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle'),
        ];
    }
}
