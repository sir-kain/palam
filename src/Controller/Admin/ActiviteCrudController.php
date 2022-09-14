<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActiviteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activite::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle'),
            DateField::new('date_debut'),
            DateField::new('date_fin'),
            AssociationField::new('parent_id'),
            AssociationField::new('responsable'),
            TextField::new('niveau_achevement'),
        ];
    }
}
