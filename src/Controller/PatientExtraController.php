<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Entity\Patient;


use App\Entity\Medicat;
use App\Entity\Historia;

use App\Entity\Type;
use App\Entity\User;
use App\Entity\Place;
use App\Entity\Opera;
use App\Entity\Treatment;


use App\Form\MedicatType;
use App\Form\HistoriaType;
use App\Form\OperaType;

use Doctrine\ORM\EntityManagerInterface;


/**
 * Controller used to manage current user.
 *
 * @Security("is_granted('ROLE_USER')")
 *
 */
class PatientExtraController extends AbstractController
{

    /**
     * @Route("/{slug}/patient/{id}/new/medicat", methods={"GET", "POST"}, name="medicat_new")
     * @param Request $request
     * @param $slug
     * @param Patient $patient
     * @return Response
     */
    public function newMed(Request $request, $slug, Patient $patient): Response
    {
        $user = $this->getUser();
        $center = $user->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);

        $medicat = new Medicat();
        $medicat->setUser($user);
        $medicat->setPatient($patient);

        $form = $this->createForm(MedicatType::class, $medicat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();            
            $em->persist($medicat);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('patient_show', ['slug' => $slug,  'id' => $patient->getId()]);
        } 

        return $this->render('/patient/medicat/new.html.twig', [
            'slug' => $slug,
            'patient' => $patient,
            'medicat' => $medicat,
            'form' => $form->createView(),          
        ]);

    }

    /**
     * @Route("/medicat/{id}", methods={"POST"}, name="medicat_stop")
     * @param Medicat $medicat
     * @return Response
     */
    public function medicatStop(Medicat $medicat)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $medicat->setStopAt(new \DateTime("now"));
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        return new Response(null, 204);
    }


    /**
     * @Route("/{slug}/patient/{id}/new/historia", methods={"GET", "POST"}, name="historia_new")
     * @param Request $request
     * @param $slug
     * @param Patient $patient
     * @return Response
     */
    public function newHis(Request $request, $slug, Patient $patient): Response
    {
        $user = $this->getUser();
        $center = $user->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);

        $historia = new Historia();
        $historia->setUser($user);
        $historia->setPatient($patient);

        $form = $this->createForm(HistoriaType::class, $historia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($historia);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId()]);
        } 

        return $this->render('/patient/historia/new.html.twig', [
            'center' => $center,
            'patient' => $patient,
            'historia' => $historia,
            'form' => $form->createView(),          
        ]);

    }


    /**
     * @Route("/{slug}/patient/{id}/new/medic-act", methods={"GET", "POST"}, name="opera_new")
     * @param Request $request
     * @param $slug
     * @param Patient $patient
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function newOpera(Request $request, $slug, Patient $patient, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $centerId = $this->getUser()->getCenter()->getId();
        
        //var_dump($centerId);die;

        $this->denyAccessUnlessGranted('PATIENT_EDIT', $patient);

        $repository = $em->getRepository(Type::class);
        $types = $repository->findBy(['center' => $centerId], ['name' => 'ASC']);

        $repository = $em->getRepository(User::class);
        $medics = $repository->findBy(['center' => $centerId, 'medic' => true], ['lastname' => 'ASC']);

        $repository = $em->getRepository(Place::class);
        $places = $repository->findBy(['center' => $centerId], ['name' => 'ASC']);


        if (0){

            //var_dump($types);die;

            $opera = new Opera();
            $opera->setUser($user);
            $opera->setPatient($patient);

            $form = $this->createForm(OperaType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($opera);
                $em->flush();

                $this->addFlash('info', 'record.updated_successfully');

                return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patient->getId()]);
            } 

        }

        return $this->render('/patient/opera/new.html.twig', [

            'slug' => $slug,
            'types' => $types,
            'medics' => $medics,
            'places' => $places,
            'patient' => $patient,
        ]);
    }

    /**
     * @Route("/{slug}/save/treatment-of-patient", methods={"POST"}, name="opera_save")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $slug
     * @return Response
     */
    public function saveOpera(Request $request, EntityManagerInterface $em, $slug): Response
    {

        $patientId = $request->request->get('patientId');
        $treatmentId = $request->request->get('treatmentId');
        $userId = $request->request->get('userId');
        $placeId = $request->request->get('placeId');

        $madeAt = $request->request->get('madeAt');

        //var_dump($madeAt);die;

        $dateMod = substr($madeAt,6,4) . '-' . substr($madeAt,3,2) . '-' . substr($madeAt,0,2);

        $mod = new \DateTime($dateMod);
        //var_dump($mod);die;

        $repository = $em->getRepository(User::class);
        $user = $repository->find($userId);

        $repository = $em->getRepository(Patient::class);
        $patient = $repository->find($patientId);        

        $repository = $em->getRepository(Place::class);
        $place = $repository->find($placeId);

        $repository = $em->getRepository(Treatment::class);
        $treatment = $repository->find($treatmentId);


        $opera = new Opera();

        $opera->setUser($user);
        $opera->setPatient($patient);
        $opera->setPlace($place);
        $opera->setTreatment($treatment);

        $opera->setValue($treatment->getValue());

        $opera->setMadeAt($mod);

        $em->persist($opera);
        $em->flush();

        return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patientId]);        

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
            'operaForm' => $formOpera->createView(),
        ]);
    }



}






