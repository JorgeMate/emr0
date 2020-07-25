<?php

namespace App\Repository;

use App\Entity\DocImgPatient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocImgPatient|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocImgPatient|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocImgPatient[]    findAll()
 * @method DocImgPatient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocImgPatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocImgPatient::class);
    }

    // /**
    //  * @return DocImgPatient[] Returns an array of DocImgPatient objects
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
    public function findOneBySomeField($value): ?DocImgPatient
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
