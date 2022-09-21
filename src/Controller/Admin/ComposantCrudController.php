<?php

namespace App\Controller\Admin;

use App\Entity\Composant;
use App\Repository\ComposantRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
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
        assert($entityManager instanceof ComposantRepository);

        // Excel file name for download 
        $fileName = "composants_" . date('Y-m-d') . ".xls";

        // Column names 
        $fields = ['ACTIVITES', 'DUREE', 'DEBUT', 'FIN', 'RESPONSABLES', '% ACHEVEMENT'];

        // Display column names as first row 
        $excelData = implode("\t", array_values($fields)) . "\n";

        // Fetch records from database 
        foreach ($entityManager->getOrderedList() as $row) {
            $line = [$row['libelle'], $row['days'], $row['debut'], $row['fin'], $row['responsable'], $row['achevement']];
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

    // Filter the excel data 
    private function filterData(&$str)
    {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }
}
