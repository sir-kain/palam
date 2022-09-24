<?php

namespace App\Controller\Admin;

use App\Entity\Responsable;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ResponsableCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Responsable::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplates([
                'crud/edit' => 'admin/responsable/edit.html.twig',
                'crud/new' => 'admin/responsable/new.html.twig',
            ]);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle'),
            AssociationField::new('region'),
            AssociationField::new('departement'),
            AssociationField::new('commune'),
        ];
    }
}
