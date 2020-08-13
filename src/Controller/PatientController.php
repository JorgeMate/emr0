<?php

namespace App\Controller;

use SuperSaaS\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;


use App\Entity\Patient;

use App\Entity\Consult;
use App\Entity\Medicat;
use App\Entity\Historia;
use App\Entity\Opera;

use App\Entity\DocPatient;
use App\Entity\DocImgPatient;


use App\Form\PatientType;
use App\Form\ConsultType;

use App\Form\DocPatientType;
use App\Form\DocImgPatientType;

use App\Service\UploaderHelper;
use Knp\Component\Pager\PaginatorInterface;

use App\Repository\PatientRepository;

/**
 * Controller used to manage current user.
 *
 * @Security("is_granted('ROLE_USER')")
 *
 */
class PatientController extends AbstractController
{


    /**
     * @Route("/{slug}/patient/search", methods={"GET"}, name="patient_search")
     * @param Request $request
     * @param PatientRepository $patients
     * @param $slug
     * @return Response
     * @throws \Exception
     */
    public function searchPat(Request $request, PatientRepository $patients, $slug): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);
        ///////////////////////////////////////////////////////
        if (!$request->isXmlHttpRequest()) {
            return $this->render('patient/search.html.twig',[
                'center' => $center,
            ]);
        }
        $centerId = $center->getId();

        $query = $request->query->get('q', '');

        //  $request->getSession()->set('query', $query); Recordamos la búsqueda anterior ?

        $limit = $request->query->get('l', 10);
        $foundPatients = $patients->findBySearchQuery($query, $limit, $centerId);

        $results = [];

        foreach ($foundPatients as $patient) {

            if($patient->getSex()) {
                $sex =' <i class="fa fa-venus text-danger"></i> ';
            } else {
                $sex =' <i class="fa fa-mars text-info"></i> ';
            };
 
            $dob = new \DateTime($patient->getDateOfBirth()->format('Y-m-d'));
            $today = new \DateTime('today');

            $age = $today->diff($dob)->y;
         
            $results[] = [

                'url' => $this->generateUrl('patient_show', ['id' => $patient->getId(), 'slug' => $center->getSlug()]),

                'id' => htmlspecialchars($patient->getId(), ENT_COMPAT | ENT_HTML5),
                'firstname' => htmlspecialchars($patient->getFirstname(), ENT_COMPAT | ENT_HTML5),
                'lastname' => htmlspecialchars($patient->getLastname(), ENT_COMPAT | ENT_HTML5),
                'birthdate' => $patient->getDateOfBirth()->format('d/m/Y'),
                'sex' => $sex,
                'age' => $age,
            ];
        }
        return $this->json($results);        

    }


    /**
     * @Route("/{slug}/patients", methods={"GET"}, name="patient_index")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function indexPat(Request $request, PaginatorInterface $paginator)
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

        #$queryBuilder->setMaxResults('100');
            
       
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

     

        return $this->render('patient/index.html.twig', [
             
            'group' => $group,
            'center' => $center,
            'pagination' => $pagination, 
            'order' => 'íd',
        ]);

    }


    /**
     * @Route("/{slug}/new/patient", methods={"GET", "POST"}, name="patient_new")
     *
     * NUEVO paciente (del usuario)
     * @param Request $request
     * @param $slug
     * @return Response
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
     * @param Request $request
     * @param $slug
     * @param Patient $patient
     * @param EntityManagerInterface $em
     * @param UploaderHelper $uploaderHelper
     * @return Response
     * @throws \Exception
     */
    public function showPat(Request $request, $slug, Patient $patient, EntityManagerInterface $em, UploaderHelper $uploaderHelper): Response
    {
        $this->denyAccessUnlessGranted('PATIENT_VIEW', $patient);

        $patId = $patient->getId();
        
        $center = $this->getUser()->getCenter();

        $agendas = null;
        $ac_name = null;
        $api_key = null;
        $checksum = null;
        $arguments = null;

        if($center->getSsaasAccountName() && $center->getSsaasApiKey()) {

            $ac_name = $center->getSsaasAccountName();
            $api_key = $center->getSsaasApiKey();

            $client = new Client();

            $client->api_key = $api_key;
            $client->account_name = $ac_name;
            $agendas = $client->schedules->getList();

            $checksum = md5($ac_name . $api_key . $this->getUser()->getEmail());

            $SS_1_r = $patient->getId() . ' - ' . ' ' . $patient->getFirstname() . ' ' . $patient->getLastname();

            if($patient->getSex() == 1){
                $SS_2_r = "(V) ";
            } else {
                if($patient->getSex() == 0){
                    $SS_2_r = "(M) ";
                } else {
                    $SS_2_r = "(?) ";
                }
            }

            $SS_2_r .= $patient->getDateOfBirth()->format('d/m/Y');
            $SS_2_r .= ' (' . $patient->getCel() . ' - ' . $patient->getTel() . ')';
            $SS_2_r .= ' BSN ' . $patient->getCode1();
            if (! is_null($patient->getInsurance()) ){
                $SS_2_r .=  ' > ' . $patient->getInsurance()->getName();
            };



            $arguments = "?res[field_1_r]=" . $SS_1_r . "&res[field_2_r]=" . $SS_2_r;

        }




                
        $repository = $em->getRepository(Consult::class);
        $consults = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        $repository = $em->getRepository(Historia::class);
        $historias = $repository->findBy(['patient' => $patId], ['date' => 'DESC']);

        $repository = $em->getRepository(Medicat::class);
        $medicats = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        $repository = $em->getRepository(Opera::class);
        $operas = $repository->findBy(['patient' => $patId], ['created_at' => 'DESC']);

        ///////////////////////////////////////////////
        # $debts = $repository->findNotPaidOpera($patId); 
        // var_dump($debts);die;

        $repository = $em->getRepository(docImgPatient::class);
        $imgs = $repository->findBy(['patient' => $patId], ['updated_at' => 'DESC']);
        $repository = $em->getRepository(docPatient::class);
        $docs = $repository->findBy(['patient' => $patId], ['updated_at' => 'DESC']);

        // Formulario de CONSULTAS

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

        // Formulario de IMAGENES

        $storedImg = new DocImgPatient();
        $storedImg->setPatient($patient);
        $storedImg->setVisible(true);
        // ????????????????????/?????????

        $formImg = $this->createForm(DocImgPatientType::class, $storedImg);
        $formImg->handleRequest($request);

        if ($formImg->isSubmitted() && $formImg->isValid()) {

            #dd($formImg['docFile']->getData());

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $formImg['docFile']->getData();

            if ($uploadedFile){

                $newFilename = $uploaderHelper->uploadPatientImage($uploadedFile, $storedImg->getName());

                $storedImg->setName($newFilename);
                $storedImg->setOriginalFilename($uploadedFile->getClientOriginalName());
                $storedImg->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
                $storedImg->setDocSize($uploadedFile->getSize() ?? '0');

                $em->persist($storedImg);
                $em->flush();
                    
                $this->addFlash('info', 'img.up_suc');
    
            };

            return $this->redirectToRoute('patient_show', ['slug' =>$slug ,'id' => $patient->getId() ] );

        }

        // Formulario de DOCUMENTOS

        $storedDoc = new DocPatient();
        $storedDoc->setPatient($patient);
        $storedDoc->setVisible(true);
        
        $formDoc = $this->createForm(DocPatientType::class, $storedDoc);
        $formDoc->handleRequest($request);

        if ($formDoc->isSubmitted() && $formDoc->isValid()) {

            
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $formDoc['docFile']->getData();

            if ($uploadedFile){

                $newFilename = $uploaderHelper->uploadPatientDoc($uploadedFile, $storedImg->getName());

                $storedDoc->setName($newFilename);                
                $storedDoc->setOriginalFilename($uploadedFile->getClientOriginalName());
                $storedDoc->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
                $storedDoc->setDocSize($uploadedFile->getSize() ?? '0');

                $em->persist($storedDoc);
                $em->flush();

                $this->addFlash('info', 'doc.up_suc');

            };

            #$slug = $patient->getUser()->getCenter()->getSlug();
            return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId() ] );
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
            'docs' => $docs,

            'agendas' => $agendas,
            'ac_name' => $ac_name,
            'api_key' => $api_key,
            'checksum' => $checksum,
            'arguments' => $arguments,

            'formConsult' => $formConsult->createView(),
            'formDoc' => $formDoc->createView(),
            'formImg' => $formImg->createView(),

            'show_confirmation' => true,
            
        ]);
    }

    /**
     * @Route("{slug}/patient/{id}/edit", methods={"GET", "POST"}, name="patient_edit")
     *
     * EDITAR el paciente id
     * @param $slug
     * @param Request $request
     * @param Patient $patient
     * @return Response
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


    /**
     * @Route("/{slug}/treatment/{id}/edit", methods={"GET","POST"}, name="opera_edit")
     * @param Request $request
     * @param Opera $opera
     * @param EntityManagerInterface $em
     * @param $slug
     * @return Response
     */
    public function editOpera(Request $request, Opera $opera, EntityManagerInterface $em, $slug): Response
    {

        $patient = $opera->getPatient();

        $this->denyAccessUnlessGranted('PATIENT_EDIT', $patient);

        $formOpera = $this->createForm(OperaType::class, $opera);
        $formOpera->handleRequest($request);

        if ($formOpera->isSubmitted() && $formOpera->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId()] );
        }

        return $this->render('patient/opera/edit.html.twig', [

            'opera' => $opera,
            'form' => $formOpera->createView(),
        ]);
    }








}
