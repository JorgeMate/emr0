<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Patient;

use App\Entity\Consult;
use App\Entity\Medicat;
use App\Entity\Historia;
use App\Entity\Opera;

use App\Entity\DocPatient;


use App\Form\PatientType;
use App\Form\ConsultType;

use App\Form\ DocPatientType;



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

    /**
     * @Route("{slug}/patient/{id}/show", methods={"GET", "POST"}, name="patient_show")
     * 
     * MOSTRAR el paciente id
     */
    public function showPat(Request $request, $slug, Patient $patient, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('PATIENT_VIEW', $patient);

        $patId = $patient->getId();
        
        $center = $this->getUser()->getCenter();
                
        $repository = $em->getRepository(Consult::class);
        $consults = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        $repository = $em->getRepository(Historia::class);
        $historias = $repository->findBy(['patient' => $patId], ['date' => 'DESC']);

        $repository = $em->getRepository(Medicat::class);
        $medicats = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        $repository = $em->getRepository(Opera::class);
        $operas = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        ///////////////////////////////////////////////
        #$debts = $repository->findNotPaidOpera($patId); 

        //var_dump($debts);die;

        $repository = $em->getRepository(docPatient::class);
        $imgs = $repository->findBy(['patient' => $patId, 'mime_type' => 'image/jpeg'], ['updated_at' => 'DESC']);
        #$docs = $repository->findBy(['patient' => $patId, 'mime_type' => 'application/pdf'], ['updated_at' => 'DESC']);



        $consult = new Consult();
        $formConsult = $this->createForm(ConsultType::class, $consult);
        $formConsult->handleRequest($request);
        if ($formConsult->isSubmitted() && $formConsult->isValid()) {

            $consult->setPatient($patient);
            $consult->setUser($this->getUser());

            $em->persist($consult);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId() ] );

        }


        $storedImg = new DocPatient();
        $storedImg->setPatient($patient);
        $storedImg->setVisible(true);

        $formImg = $this->createForm(DocPatientType::class, $storedImg);
        $formImg->handleRequest($request);

        if ($formImg->isSubmitted() && $formImg->isValid()) {
                
            $em->persist($storedImg);
            $em->flush();
                
            $this->addFlash('info', 'img.up_suc');
            $slug = $patient->getUser()->getCenter()->getSlug();

            return $this->redirectToRoute('patient_show', ['slug' =>$slug ,'id' => $patient->getId() ] );

        }





        if (false){


            // Entramos al mismo repositorio por los 2 lados

            $formDoc = $this->createForm(StoredDocType::class, $storedImg);
            $formDoc->handleRequest($request);
            if ($formDoc->isSubmitted() && $formDoc->isValid()) {

                $em->persist($storedImg);
                $em->flush();
                    
                $this->addFlash('info', 'doc.up_suc');
                $slug = $patient->getUser()->getCenter()->getSlug();

                return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId() ] );
                
            }

            $formImg = $this->createForm(StoredImgType::class, $storedImg);
            $formImg->handleRequest($request);

        }




        return $this->render('patient/show.html.twig', [
           
            'center' => $center,
            'patient' => $patient,
            'consults' => $consults,
            'historias' => $historias,
            'medicats' => $medicats,
            'operas' => $operas,

            #'debts' => $debts,

            'imgs' => $imgs,
            #'docs' => $docs,

            'formConsult' => $formConsult->createView(),
            #'formDoc' => $formDoc->createView(),
            'formImg' => $formImg->createView(),

            'show_confirmation' => true,
            
        ]);
    }

    /**
     * @Route("{slug}/patient/{id}/edit", methods={"GET", "POST"}, name="patient_edit")
     * 
     * EDITAR el paciente id
     */
    public function editPat($slug, Request $request, Patient $patient): Response
    {

        $this->denyAccessUnlessGranted('PATIENT_EDIT', $patient);

        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            
            $this->addFlash('info', 'record.updated_successfully');
            
            return $this->redirectToRoute('patient_show', 
                ['slug' => $slug, 'id' => $patient->getId()] );
        }

        return $this->render('patient/edit.html.twig', [
           
            'patient' => $patient,
            'formPat' => $form->createView(),
        ]);

    }




}
