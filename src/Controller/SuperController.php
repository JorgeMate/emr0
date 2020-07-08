<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use App\Entity\Center;
use App\Form\CenterType;

/**
 * Controller used to manage ALL !!!
 *
 * @Route("/super")
 * @Security("is_granted('ROLE_SUPER_ADMIN')")
 *
 */
class SuperController extends AbstractController
{
    /**
     * @Route("/cpanel", name="super_cpanel")
     */
    public function cpanel()
    {
        return $this->render('super/cpanel.html.twig', [
            'controller_name' => 'SuperController',
        ]);
    }


    /**
    * @Route("/centers", methods={"GET"}, name="centers_index")
    */
    public function centerIndex()
    {
        $centers = $this->getDoctrine()
            ->getRepository(Center::class)
            ->findAll();

            if (!$centers) {
                throw $this->createNotFoundException(
                    'No centers found'
                );
            }

        return $this->render('super/center/index.html.twig', [
            'centers' => $centers,
        ]);
    }

    /**
     * @Route("/center/new", methods={"GET", "POST"}, name="center_new")
     */
    public function centerNew(Request $request): Response
    {
        $center = new Center();
        $center->setEnabled(true);
        
        $form = $this->createForm(CenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($center);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'record.updated_successfully');

            return $this->redirectToRoute('centers_index');
        }

        return $this->render('super/center/new.html.twig', [
            'center' => $center,
            'form' => $form->createView(),
        ]);
    }    



}
