<?php

namespace App\Repository;

use App\Entity\Indicateur;
use App\Entity\TypeIndicateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Indicateur>
 *
 * @method Indicateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Indicateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Indicateur[]    findAll()
 * @method Indicateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndicateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private TypeIndicateurRepository $typeIndicateurRepository)
    {
        parent::__construct($registry, Indicateur::class);
    }

    public function add(Indicateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Indicateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Indicateur[] Returns an array of Indicateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Indicateur
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getOrderedList()
    {
        $list = [];
        foreach ((array) $this->typeIndicateurRepository->findAll() as $typeIndicateur) {
            assert($typeIndicateur instanceof TypeIndicateur);
            array_push(
                $list,
                [
                    'code' => $typeIndicateur->getLibelle(),
                    'libelle' => '',
                    'period' => '',
                    'source' => '',
                    'analyse' => '',
                ]
            );


            foreach ($typeIndicateur->getIndicateurs()->toArray() as $indicateur) {
                assert($indicateur instanceof Indicateur);
                array_push($list, [
                    'code' => $indicateur->getCode(),
                    'libelle' => $indicateur->getLibelle(),
                    'period' => $indicateur->getPeriodicite()->getLibelle(),
                    'source' => $indicateur->getSource(),
                    'analyse' => $indicateur->getAnalyseInterpretation(),
                ]);
            }
        }
        return $list;
    }
}
