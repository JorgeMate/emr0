<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Center;


/**
 * Controller used to manage current center.
 *
 * @Route("/center")
 * @Security("is_granted('ROLE_ADMIN')")
 *
 */
class CenterController extends AbstractController
{
    /**
     * @Route("/center", name="center_cpanel")
     */
    public function cpanel()
    {
        return $this->render('center/cpanel.html.twig', [
            'controller_name' => 'CenterController',
        ]);
    }

    /**
     * @Route("/{slug}/users", methods={"GET"}, name="users_index")
     * 
     * LISTAR todos los usuarios del centro slug
     */
    public function indexUsers($slug): Response
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Center::class);
        $center = $repository->findOneBy(['slug' => $slug]);

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $users = $center->getUsers();
        
        return $this->render('center/user/index.html.twig', [
             
            'slug' => $slug,
            'users' => $users,
            'center' => $center 
        ]);
    }





}
