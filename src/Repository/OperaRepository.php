<?php

namespace App\Repository;

use App\Entity\Opera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Opera|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opera|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opera[]    findAll()
 * @method Opera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opera::class);
    }

    /**
     * //  *
     * @param $user_id
     * @param $date1
     * @param $date2
     * @return Opera[] Returns an array of Opera objects
     * //
     */
        public function findByDates($user_id, $date1, $date2)
    {

        //var_dump($user_id, $date1, $date2);die;

        $dat1 = substr($date1,6,4) . '-' . substr($date1,3,2) . '-' . substr($date1,0,2);
        $dat2 = substr($date2,6,4) . '-' . substr($date2,3,2) . '-' . substr($date2,0,2);




        $qb =  $this->createQueryBuilder('o')
            ->innerJoin('o.user','u')
            ->andWhere('u.id = :user_id')

            ->andWhere('o.made_at >= :date1 AND o.made_at <= :date2')

            ->setParameter('user_id', $user_id)
            ->setParameter('date1', $dat1)
            ->setParameter('date2', $dat2)
            ->groupBy('o.treatment')
            ->orderBy('o.treatment', 'ASC')
            
            ->getQuery()
            ->getResult()
        ;
        $dql = $qb->getDql();
        var_dump($dql);
        return $qb;
    }


    /*
    public function findOneBySomeField($value): ?Opera
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
