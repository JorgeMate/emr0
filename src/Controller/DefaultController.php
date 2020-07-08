<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use App\Entity\Center;
use App\Form\NewCenterType;

use App\Entity\User;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;




class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            # 'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/register", methods={"GET", "POST"}, name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {

        $this->passUniversal = '4444';

        $center = new Center();
        $center->setEnabled(true);
        
        $form = $this->createForm(NewCenterType::class, $center);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->persist($center);
            $this->getDoctrine()->getManager()->flush();

            // Insertamos el usuario/propietario

            $user = new User();
            $user->setCenter($center);
            $user->setCenterUser(true);
            $user->setFirstName('');
            $user->setLastName($center->getContactPerson());
            $user->setEmail($center->getEmail());
            $user->setTel($center->getTel());

            $this->passUniversalEncoded = $encoder->encodePassword(
                $user,
                $this->passUniversal
            );
    



            $this->addFlash('success', 'message.request_ok');

            return $this->redirectToRoute('default');
        }

        return $this->render('default/register.html.twig', [
            'center' => $center,
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/whatIs", name="whatIs")
     */
    public function what()
    {
        return $this->render('default/whatIs.html.twig', [
            # 'controller_name' => 'DefaultController',
        ]);

    }



}
