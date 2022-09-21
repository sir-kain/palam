<?php

namespace App\Controller\Admin;

use App\Entity\Composant;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ComposantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Composant::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle', 'Libelle'),
            TextField::new('days', 'Durée')->hideOnForm(),
            DateField::new('date_debut', 'Date debut')->hideOnForm(),
            DateField::new('date_fin', 'Date fin')->hideOnForm(),
            IntegerField::new('niveau_achevement', '% achevement')->hideOnForm(),
        ];
    }
}
