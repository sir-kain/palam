<?php

namespace App\Controller\Admin;

use App\Entity\Indicateur;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
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
            AssociationField::new('type_indicateur', 'Type indicateur'),
            TextField::new('code', 'N'),
            TextField::new('libelle', 'Indicateurs'),
            AssociationField::new('periodicite', 'Periodicité de collecte des données'),
            TextField::new('source', 'source de données'),
            TextEditorField::new('analyse_interpretation', 'Analyse et interprétation des données'),
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): ORMQueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // dd($queryBuilder->getDQL());
        // // // if user defined sort is not set
        // // if (0 === count($searchDto->getSort())) {
        // //     $queryBuilder
        // //         ->addSelect('CONCAT(entity.first_name, \' \', entity.last_name) AS HIDDEN full_name')
        // //         ->addOrderBy('full_name', 'DESC');
        // // }

        return $queryBuilder;
    }
}
