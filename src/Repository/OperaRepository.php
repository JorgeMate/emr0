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
     * @param $user_id
     * @param $treatment_id
     * @param $date1
     * @param $date2
     * @param $place_id
     * @param $conn_emr
     * @return void Returns an array of Opera objects
     */
    public function findByTreatment($user_id, $treatment_id, $date1, $date2, $place_id, $conn_emr)
    {
        $dat1 = substr($date1,6,4) . '-' . substr($date1,3,2) . '-' . substr($date1,0,2);
        $dat2 = substr($date2,6,4) . '-' . substr($date2,3,2) . '-' . substr($date2,0,2);

        $query1 = 'SELECT user.title, user.lastname AS lastnameD, user.firstname AS firstnameD,
                    opera.made_at, 
                    treatment.name, treatment.id AS treatmentId, type.name AS typeName,
                    patient.firstname, patient.lastname, patient.sex, patient.id AS patient_id, patient.date_of_birth AS dateOfBirth,
                    place.name AS placeName
                     
        FROM opera
        INNER JOIN user ON opera.user_id = user.id
        INNER JOIN patient ON opera.patient_id = patient.id
        INNER JOIN treatment ON opera.treatment_id = treatment.id
        INNER JOIN place ON opera.place_id = place.id
            INNER JOIN type ON type.id = treatment.type_id
        WHERE opera.user_id = :user_id 
            AND opera.made_at >= :date1 AND opera.made_at <= :date2
            AND IF(:place_id < 1, true, opera.place_id = :place_id)
            AND opera.treatment_id = :treatment_id
        ORDER BY opera.made_at DESC
        ';

        $stmt = $conn_emr->prepare($query1);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':date1', $dat1);
        $stmt->bindValue(':date2', $dat2);
        $stmt->bindValue(':place_id', $place_id);
        $stmt->bindValue(':treatment_id', $treatment_id);
        $stmt->execute();

        return $stmt->fetchAll();

    }


    /**
     * @param $user_id
     * @param $date1
     * @param $date2
     * @param $place_id
     * @param $conn_emr
     * @return Opera[] Returns an array of Opera objects
     */
     public function findByDates($user_id, $date1, $date2, $place_id, $conn_emr)
     {
        $dat1 = substr($date1,6,4) . '-' . substr($date1,3,2) . '-' . substr($date1,0,2);
        $dat2 = substr($date2,6,4) . '-' . substr($date2,3,2) . '-' . substr($date2,0,2);

        $query = "SELECT user.cod, 
                    treatment.name, treatment.id AS treatmentId, type.name AS typeName, COUNT(*) AS cuantas 
        FROM opera 
        INNER JOIN user ON opera.user_id = user.id
            
            INNER JOIN treatment ON opera.treatment_id = treatment.id
            INNER JOIN place ON opera.place_id = place.id
                INNER JOIN type ON type.id = treatment.type_id 

        WHERE opera.user_id = :user_id 
            AND opera.made_at >= :date1 AND opera.made_at <= :date2
            AND IF(:place_id < 1, true, opera.place_id = :place_id)
        GROUP BY opera.user_id, treatment.type_id, opera.treatment_id
        ORDER BY type.name, treatment.name
        "  ;

        $stmt = $conn_emr->prepare($query);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':date1', $dat1);
        $stmt->bindValue(':date2', $dat2);
        $stmt->bindValue(':place_id', $place_id);
        $stmt->execute();
        
        //var_dump($stmt->fetchAll());die;

        return $stmt->fetchAll();


     }

    /**
     * @param $user_id
     * @param $treatment_id
     * @param $date1
     * @param $date2
     * @param $place_id
     * @param $conn_emr
     * @return Opera[] Returns an array of Opera objects
     */
    public function findByDatesDetail($user_id, $treatment_id, $date1, $date2, $place_id, $conn_emr)
     {
         $dat1 = substr($date1,6,4) . '-' . substr($date1,3,2) . '-' . substr($date1,0,2);
         $dat2 = substr($date2,6,4) . '-' . substr($date2,3,2) . '-' . substr($date2,0,2);

         $query2 = "SELECT user.cod, 
                        treatment.name, treatment.id AS treatmentId, 
                        type.name AS typeName,
                        patient.firstname, patient.lastname, patient.sex, patient.id AS patient_id, patient.date_of_birth AS dateOfBirth,
                        place.name AS placeName,
                        opera.made_at
                    FROM opera
                        INNER JOIN user ON opera.user_id = user.id
                        INNER JOIN patient ON opera.patient_id = patient.id
                        INNER JOIN treatment ON opera.treatment_id = treatment.id
                        INNER JOIN place ON opera.place_id = place.id
                            INNER JOIN type ON type.id = treatment.type_id
                    WHERE opera.user_id = :user_id 
                        AND opera.made_at >= :date1 AND opera.made_at <= :date2
                        AND IF(:place_id < 1, true, opera.place_id = :place_id)
                        AND IF(:treatment_id < 1, true, opera.treatment_id = :treatment_id) 
                    ORDER BY type.name, treatment.name, opera.made_at DESC
                    ";

         $stmt = $conn_emr->prepare($query2);
         $stmt->bindValue(':user_id', $user_id);
         $stmt->bindValue(':date1', $dat1);
         $stmt->bindValue(':date2', $dat2);
         $stmt->bindValue(':place_id', $place_id);
         $stmt->bindValue(':treatment_id', $treatment_id);
         $stmt->execute();

         return $stmt->fetchAll();


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
