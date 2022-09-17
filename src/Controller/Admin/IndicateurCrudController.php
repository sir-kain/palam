<?php

namespace App\Controller\Admin;

use App\Entity\Indicateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IndicateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Indicateur::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('type_indicateur'),
            TextField::new('code'),
            TextField::new('libelle'),
            AssociationField::new('periodicite'),
            TextField::new('source'),
            TextEditorField::new('analyse_interpretation'),
        ];
    }
}
