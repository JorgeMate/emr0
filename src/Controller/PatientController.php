<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use App\Entity\Patient;

use App\Form\PatientType;


/**
 * Controller used to manage current user.
 *
 * @Security("is_granted('ROLE_USER')")
 *
 */
class PatientController extends AbstractController
{


    /**
     * @Route("/{slug}/patients", methods={"GET"}, name="patient_index")
     */
    public function indexPat(Request $request)
    {

        //$lastIdPat = $this->getDoctrine()->getRepository(Patient::class)->lastInsertedId();
        //$lastIdPat = $lastIdPat['lastIdPat'];

        //var_dump($lastIdPat);die;

        $group = '';

        $entity = $request->get('entity');
        $entity_id = $request->get('id');

        $center = $this->getUser()->getCenter();

        $em = $this->getDoctrine()->getManager();

        

        $queryBuilder = $em->createQueryBuilder($center->getId())
            ->select('p', 's', 'i') 
            ->from('App\Entity\Patient', 'p')
            ->innerJoin('p.user','u')
            ->innerJoin('u.center','c')
            ->leftJoin('p.source', 's')
            ->leftjoin('p.insurance', 'i')
            
            ->orderBy('p.id', 'DESC');
            
            // ->leftjoin('p.place', 'pl')

            // ->setParameter('last', $lastIdPat);
            // ->andWhere('p.id + 100 > :last')

        if($center->getId()){
            $queryBuilder
                ->andWhere('c.id = :val')
                ->setParameter('val', $center->getId());
        };

        if($entity && $entity_id){
            switch($entity){
            case 'ins':
                $queryBuilder
                    ->andWhere('p.insurance = :insuranceId')
                    ->setParameter('insuranceId', $entity_id);
            break;    
            case 'source':
                $queryBuilder
                    ->andWhere('p.source = :sourceId')
                    ->setParameter('sourceId', $entity_id);
            break;    
            case 'place':
                $queryBuilder
                    ->andWhere('p.place = :placeId')
                    ->setParameter('placeId', $entity_id);
            break;    

            }

        };

        $queryBuilder->setMaxResults('100');
            
        $adapter = new DoctrineORMAdapter($queryBuilder);

        $pagerfanta = new Pagerfanta($adapter);

        $pagerfanta->setMaxPerPage(10); // 10 by default
        $maxPerPage = $pagerfanta->getMaxPerPage();

        $pagerfanta->getCurrentPageOffsetStart(3);
        $pagerfanta->getCurrentPageOffsetEnd(3);

        if (isset($_GET["page"])) {
            //  $t = $pagerfanta->getNbPages();
            //  var_dump($t); die;
            $page = min($_GET["page"], $pagerfanta->getNbPages());
            $pagerfanta->setCurrentPage($page);
        }

        return $this->render('patient/index.html.twig', [
             
            'group' => $group,
            'center' => $center,
            'my_pager' => $pagerfanta,
            'order' => 'íd',
        ]);

    }


     /**
     * @Route("/{slug}/new/patient", methods={"GET", "POST"}, name="patient_new")
     * 
     * NUEVO paciente (del usuario)
     */
    public function newPat(Request $request, $slug): Response
    {

        $user = $this->getUser();
        $center = $user->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);

        // Todos pueden insertar pacientes !?

        $patient = new Patient();
        $patient->setUser($user);

        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId()]);
        }

        return $this->render('/patient/new.html.twig', [
             
            'patient' => $patient,
            'form' => $form->createView(),
            
        ]);

    }




}
