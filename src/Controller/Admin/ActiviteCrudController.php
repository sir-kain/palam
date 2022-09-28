<?php

namespace App\Controller\Admin;

use App\Entity\Activite;
use App\Repository\ActiviteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
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
            AssociationField::new('parent_id', 'Activité parente'),
            TextField::new('code', 'Code activité'),
            TextField::new('libelle', 'Activités'),
            TextField::new('days', 'Durée')->onlyOnIndex(),
            DateField::new('date_debut', 'Date debut'),
            DateField::new('date_fin', 'Date fin'),
            AssociationField::new('responsable', 'Responsable'),
            AssociationField::new('composant', 'Composant')->hideOnIndex(),
            IntegerField::new('niveau_achevement', '% Achevement'),
        ];
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplates([
                'crud/edit' => 'admin/activite/edit.html.twig',
                'crud/new' => 'admin/activite/new.html.twig',
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
        assert($entityManager instanceof ActiviteRepository);
        $delimiter = ',';
        $filename = 'activites' . date('d-m-y') . '.csv';
        $f = fopen('php://memory', 'w');
        $fields = ['Activités', 'Durée', 'Debut', 'Fin'];
        fputcsv($f, $fields, $delimiter);
        foreach ($entityManager->getOrderedList() as $row) {
            $line = [$row['libelle'], $row['days'], $row['debut'], $row['fin']];
            fputcsv($f, $line, $delimiter);
        }

        fseek($f, 0);
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename"' . $filename . '";');

        fpassthru($f);
        exit;
    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);
        return $queryBuilder->orderBy('entity.parent_id');
    }
}
