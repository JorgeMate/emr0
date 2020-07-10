<?php

namespace App\Repository;

use App\Entity\DocUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocUser[]    findAll()
 * @method DocUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocUser::class);
    }

    // /**
    //  * @return DocUser[] Returns an array of DocUser objects
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
    public function findOneBySomeField($value): ?DocUser
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
