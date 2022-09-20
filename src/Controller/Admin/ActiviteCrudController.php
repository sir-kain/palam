<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ActiviteCrudController extends AbstractCrudController
{

    public function __constructor()
    {
    }

    public static function getEntityFqcn(): string
    {
        return Activite::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('libelle', 'Activités'),
            TextField::new('days', 'Durée')->onlyOnIndex(),
            DateField::new('date_debut', 'Date debut'),
            DateField::new('date_fin', 'Date fin'),
            AssociationField::new('parent_id', 'Activité parente'),
            AssociationField::new('responsable', 'Responsable'),
            AssociationField::new('composant', 'Composant')->hideOnIndex(),
            TextField::new('niveau_achevement', '% Achevement'),
        ];
    }

    // public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    // {
    //     $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

    //     // dd($queryBuilder->createIndexQueryBuilder());
    //     // // if user defined sort is not set
    //     // if (0 === count($searchDto->getSort())) {
    //     //     $queryBuilder
    //     //         ->addSelect('CONCAT(entity.first_name, \' \', entity.last_name) AS HIDDEN full_name')
    //     //         ->addOrderBy('full_name', 'DESC');
    //     // }

    //     return $queryBuilder->groupBy('entity.id');
    // }
}
