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
     * 
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
     * 
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
     * 
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

        
        //var_dump($types);die;

        $opera = new Opera();
        $opera->setUser($user);
        $opera->setPatient($patient);


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
     * 
     */
    public function saveOpera(Request $request, EntityManagerInterface $em, $slug): Response
    {

        $patientId = $request->request->get('patientId');
        $treatmentId = $request->request->get('treatmentId');
        $userId = $request->request->get('userId');
        $placeId = $request->request->get('placeId');

        $madeAt = $request->request->get('madeAt');

        $repository = $em->getRepository(User::class);
        $user = $repository->find($userId);

        $repository = $em->getRepository(Patient::class);
        $patient = $repository->find($patientId);        

        $repository = $em->getRepository(Place::class);
        $place = $repository->find($placeId);

        $repository = $em->getRepository(Treatment::class);
        $treatment = $repository->find($treatmentId);


        //$dateMod = substr($madeAt,6,4) . '/' . substr($madeAt,3,2) . '/' . substr($madeAt,0,2);

        //var_dump($dateMod);die;
        
        //$mod = new \DateTime($dateMod);

        $opera = new Opera();

        $opera->setUser($user);
        $opera->setPatient($patient);
        $opera->setPlace($place);
        $opera->setTreatment($treatment);

        $opera->setValue($treatment->getValue());

        $opera->setMadeAt($madeAt);

        $em->persist($opera);
        $em->flush();

        return $this->redirectToRoute('patient_show', ['slug' => $slug, 'id' => $patientId]);        

    }    

}
