<?php

namespace App\Repository;

use App\Entity\DocPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocPatient[]    findAll()
 * @method DocPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocPatient::class);
    }

    // /**
    //  * @return DocPatient[] Returns an array of DocPatient objects
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
    public function findOneBySomeField($value): ?DocPatient
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
