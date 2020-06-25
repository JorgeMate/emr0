<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use App\Entity\Center;

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




}
