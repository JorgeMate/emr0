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

use App\Form\MedicatType;
use App\Form\HistoriaType;


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


}
