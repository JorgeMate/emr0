<?php

namespace App\Repository;

use App\Entity\DocCenterGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocCenterGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocCenterGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocCenterGroup[]    findAll()
 * @method DocCenterGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocCenterGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocCenterGroup::class);
    }

    // /**
    //  * @return DocCenterGroup[] Returns an array of DocCenterGroup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocCenterGroup
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
