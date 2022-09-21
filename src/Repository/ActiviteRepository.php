<?php

namespace App\Repository;

use App\Entity\Activite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Activite>
 *
 * @method Activite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activite[]    findAll()
 * @method Activite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activite::class);
    }

    public function add(Activite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Activite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getDays(): ?string
    {
        if ($this->getParentId()) {
            if ($this->getDateFin() && $this->getDateDebut()) {
                return date_diff($this->getDateFin(), $this->getDateDebut())->days;
            }
        } else {
        }

        return $this->days;
    }

    //    /**
    //     * @return Activite[] Returns an array of Activite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Activite
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Activite[] Returns an array of Activite objects
     */
    public function findParentActivities(): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.parent_id is NULL')
            ->getQuery()
            ->getResult();
    }

    public function findOldestActivity($parentId): ?Activite
    {
        return $this->findOneBy(['parent_id' => $parentId], ['date_fin' => 'DESC']);
    }
    public function findEarliestActivity($parentId): ?Activite
    {
        return $this->findOneBy(['parent_id' => $parentId], ['date_debut' => 'ASC']);
    }

    public function getOrderedList()
    {
        $list = [];
        foreach ((array) $this->findAll() as $activite) {
            assert($activite instanceof Activite);
            if (is_null($activite->getParentId())) {
                array_push(
                    $list,
                    [
                        'libelle' => $activite->getLibelle(),
                        'days' => $activite->getDays() . ' Jours',
                        'debut' => date_format($activite->getDateDebut(), 'd-m-Y'),
                        'fin' => date_format($activite->getDateFin(), 'd-m-Y')
                    ]
                );
                $activiteChilden = array_map(function ($activiteChild) {
                    return [
                        'libelle' => $activiteChild->getLibelle(),
                        'days' => $activiteChild->getDays() . ' Jours',
                        'debut' => date_format($activiteChild->getDateDebut(), 'd-m-Y'),
                        'fin' => date_format($activiteChild->getDateFin(), 'd-m-Y')
                    ];
                }, $this->findBy(['parent_id' => $activite->getId()]));
                array_push($list, ...$activiteChilden);
            }
        }
        return $list;
    }
}
