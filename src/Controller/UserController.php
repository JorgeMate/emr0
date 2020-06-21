<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Controller used to manage current user.
 *
 * @Route("/user")
 * @Security("is_granted('ROLE_USER')")
 *
 */
class UserController extends AbstractController
{
    /**
     * @Route("/cpanel", name="user_cpanel")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/profile/edit", methods={"GET", "POST"}, name="profile_edit")
     */
    public function profileEdit(Request $request): Response
    {

        $user = $this->getUser();
        #$slug = $user->getCenter()->getSlug();

        if(false){

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'record.updated_successfully');
            return $this->redirectToRoute('user_cpanel', ['slug' => $slug]);
        }

        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
        #    'form' => $form->createView(),
        ]);

    }


}
