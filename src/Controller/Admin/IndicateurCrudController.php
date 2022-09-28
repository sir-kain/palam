<?php

namespace App\Controller\Admin;

use App\Entity\Indicateur;
use App\Repository\IndicateurRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
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

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('composant');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('type_indicateur', 'Type indicateur'),
            AssociationField::new('composant', 'Composant'),
            AssociationField::new('responsable', 'Responsable'),
            TextField::new('code', 'Numéro'),
            TextField::new('libelle', 'Indicateurs'),
            AssociationField::new('periodicite', 'Periodicité de collecte des données'),
            TextField::new('source', 'source de données'),
            TextEditorField::new('analyse_interpretation', 'Analyse et interprétation des données'),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplates([
                'crud/edit' => 'admin/indicateur/edit.html.twig',
                'crud/new' => 'admin/indicateur/new.html.twig',
            ]);
    }


    public function configureActions(Actions $actions): Actions
    {
        $exportCSV = Action::new("exportCSV", 'Export excel')
            ->setIcon('fas fa-download')
            ->linkToCrudAction('downloadCSV');
        return $actions->addBatchAction($exportCSV);
    }

    public function downloadCSV(BatchActionDto $batchActionDto)
    {
        $className = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getRepository($className);
        assert($entityManager instanceof IndicateurRepository);

        // Excel file name for download 
        $fileName = "indicateurs_" . date('Y-m-d') . ".xls";

        // Column names 
        $fields = ['No', 'INDICATEURS', 'Périodicité de collecte des données', 'Source des données', 'Analyse et interprétation des données'];

        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n";

        // Fetch records from database 
        foreach ($entityManager->getOrderedList() as $row) {
            $line = [$row['code'], $row['libelle'], $row['period'], $row['source'], $row['analyse']];
            array_walk($line, function ($row) {
                return $this->filterData($row);
            });
            $excelData .= implode("\t", array_values($line)) . "\n";
        }

        // Headers for download 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        // Render excel data 
        echo $excelData;

        exit;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): ORMQueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        return $queryBuilder->orderBy('entity.type_indicateur');
    }

    // Filter the excel data 
    private function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
}
