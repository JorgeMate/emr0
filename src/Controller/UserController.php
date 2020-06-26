<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Form\UserType;
use App\Form\Type\ChangePasswordType;


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
     * @Route("/{slug}/cpanel", methods={"GET","POST"}, name="user_cpanel")
     */
    public function userCpanel($slug): Response
    {
        $user = $this->getUser();
        $center = $this->getUser()->getCenter();
        #$groups = $center->getCenterDocGroups();
        $groups = null;

        $client = null;
        $agendas = null;
        $checksum = null;

        if($center->getSsaasAccountName() && $center->getSsaasApiKey()){

            // Comprobamos si el usuario tiene uso autorizado a las agendas
            // TODO, también moverlo a __consttruct para hacerlo una sola vez

            if(false){

                $client = new Client();  // SaasS
                /////////////////////////////////
                $client->account_name = $center->getSsaasAccountName();
                $client->api_key = $center->getSsaasApiKey();

            //    $usersSaas = $client->users->getList();
            //    var_dump($usersSaas);die;

                $agendas = $client->schedules->getList();
                //var_dump($agendas);die;

                $checksum = md5($client->account_name . $client->api_key . $user->getEmail());
                //var_dump($checksum);die;
            }
        }

        return $this->render('user/cpanel.html.twig', [

            'user' => $user,
            'center' => $center,
            'groups' => $groups,

            'client' => $client,
            'agendas' => $agendas,

            'checksum' => $checksum,
             
        ]);
    }

    /**
     * @Route("/profile/edit", methods={"GET", "POST"}, name="profile_edit")
     */
    public function profileEdit(Request $request): Response
    {

        $user = $this->getUser();
        $slug = $user->getCenter()->getSlug();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('info', 'record.updated_successfully');
            return $this->redirectToRoute('user_cpanel', ['slug' => $slug]);
        }

        
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);

    }

        /**
     * @Route("/profile/change-password", methods={"GET", "POST"}, name="user_change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('logout');
        }


        return $this->render('user/change_password.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }    




}
