<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Insurance;

use App\Form\InsuranceType;

/**
 * Controller used to manage current center entities.
 *
 * @Route("/center")
 * @Security("is_granted('ROLE_ADMIN')")
 *
 */

class EntityController extends AbstractController
{
    /**
     * @Route("/{slug}/insurances", methods={"GET"}, name="insurances_index")
     * 
     * LISTAR todos las cias de seguro del centro id
     */
    public function insurancesIndex($slug): Response
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Insurance::class);
        $insurances = $repository->findBy(['center' => $center->getId()], ['name' => 'ASC']);
        
        return $this->render('entity/insurance/index.html.twig', [

            'slug' => $slug,
            'insurances' => $insurances,
        ]);
    }


    /**
     * @Route("/{slug}/insurance/new", methods={"GET", "POST"}, name="insurance_new")
     * 
     */
    public function insuranceNew(Request $request, $slug): Response
    {

        $center = $this->getUser()->getCenter();
        
        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);
        
        $insurance = new Insurance();
        $insurance->setCenter($center);

        $form = $this->createForm(InsuranceType::class, $insurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($insurance);
            $em->flush();

            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('insurances_index', ['slug' => $slug]);
        }

        return $this->render('entity/insurance/edit.html.twig', [
             
            'insurance' => $insurance,
            'form' => $form->createView(),
            
        ]);

    }

  /**
     * @Route("/{slug}/insurance/{id}/edit", methods={"GET", "POST"}, name="insurance_edit")
     * 
     */
    public function insuranceEdit(Request $request, $slug, Insurance $insurance)
    {
        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_EDIT', $center);        

        $form = $this->createForm(InsuranceType::class, $insurance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('info', 'record.updated_successfully');

            return $this->redirectToRoute('insurances_index', ['slug' => $slug] );
        }

        return $this->render('entity/insurance/edit.html.twig', [
             
            'insurance' => $insurance,
            'form' => $form->createView(),
        ]);
    }




}
