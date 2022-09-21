<?php

namespace App\Repository;

use App\Entity\Activite;
use App\Entity\Composant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Composant>
 *
 * @method Composant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composant[]    findAll()
 * @method Composant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private ActiviteRepository $activiteRepository)
    {
        parent::__construct($registry, Composant::class);
    }

    public function add(Composant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Composant $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Composant[] Returns an array of Composant objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Composant
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function getOrderedList()
    {
        $list = [];
        foreach ((array) $this->findAll() as $composant) {
            assert($composant instanceof Composant);
            array_push(
                $list,
                [
                    'libelle' => $composant->getLibelle(),
                    'days' => $composant->getDays() . ' Jours',
                    'debut' => date_format($composant->getDateDebut(), 'd-m-Y'),
                    'fin' => date_format($composant->getDateFin(), 'd-m-Y'),
                    'responsable' => '',
                    'achevement' => $composant->getNiveauAchevement() . ' %',
                ]
            );

            $activiteParents = array_filter($composant->getActivites()->toArray(), function ($activite) {
                return $activite->getParentId() == null;
            });
            foreach ($activiteParents as $activiteParent) {
                assert($activiteParent instanceof Activite);
                array_push($list, [
                    'libelle' => $activiteParent->getLibelle(),
                    'days' => $activiteParent->getDays() . ' Jours',
                    'debut' => date_format($activiteParent->getDateDebut(), 'd-m-Y'),
                    'fin' => date_format($activiteParent->getDateFin(), 'd-m-Y'),
                    'responsable' => $activiteParent->getResponsable()->getLibelle(),
                    'achevement' => $activiteParent->getNiveauAchevement() . ' %',
                ]);

                foreach ((array) $this->activiteRepository->findBy(['parent_id' => $activiteParent->getId()]) as $activite) {
                    assert($activite instanceof Activite);
                    array_push($list, [
                        'libelle' => $activite->getLibelle(),
                        'days' => $activite->getDays() . ' Jours',
                        'debut' => date_format($activite->getDateDebut(), 'd-m-Y'),
                        'fin' => date_format($activite->getDateFin(), 'd-m-Y'),
                        'responsable' => $activite->getResponsable()->getLibelle(),
                        'achevement' => $activite->getNiveauAchevement() . ' %',
                    ]);
                }
            }
        }
        return $list;
    }
}
