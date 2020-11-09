<?php

namespace App\Repository;

use App\Entity\ReportPart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportPart|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportPart|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportPart[]    findAll()
 * @method ReportPart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportPartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportPart::class);
    }

    // /**
    //  * @return ReportPart[] Returns an array of ReportPart objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReportPart
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
