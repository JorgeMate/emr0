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

use App\Form\DocUserType;

use App\Entity\DocCenterGroup;
use App\Entity\DocUser;


use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


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
        $groups = $center->getDocCenterGroups();
        

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


    /**
     * @Route("/{slug}/documents-groups", methods={"GET", "POST"}, name="doc_groups_index") 
     */
    public function programDocGroupsIndex(Request $request, $slug): Response
    {

        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(DocCenterGroup::class);
        $groups = $repository->findBy(['center' => $center->getId()], ['name' => 'ASC']);

        return $this->render('center/doc_groups/index.html.twig', [
             
            'slug' => $slug,
            'groups' => $groups,
        ]);     

        
    }



    /**
     * @Route("/{slug}/documents-group/{id}/index", methods={"GET", "POST"}, name="docs_index")
     * 
     */ 
    public function docsIndex(Request $request, $slug, DocCenterGroup $docCenterGroup)


    {


        $center = $this->getUser()->getCenter();

        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(DocUser::class);
        $docs = $repository->findBy(['docCenterGroup' => $docCenterGroup->getId()], ['name' => 'ASC']);

        $newDoc = new DocUser();
        $newDoc->setUser($this->getUser());
        $newDoc->setVisible(true);
        $newDoc->setDocCenterGroup($docCenterGroup);

        $formDoc = $this->createForm(DocUserType::class, $newDoc);
        $formDoc->handleRequest($request);

        if ($formDoc->isSubmitted() && $formDoc->isValid()) {

            $em->persist($newDoc);
            $em->flush();        
            $this->addFlash('info', 'doc.up_suc');
            
            return $this->redirectToRoute('docs_index', ['slug' => $slug, 'id' => $docCenterGroup->getId() ] );
        }


        return $this->render('center/doc_groups/doc_index.html.twig', [
             
            'docCenterGroup' => $docCenterGroup,
            'docs' => $docs,
            'form' => $formDoc->createView(),
        ]);     

    }

    /**
     * @Route("/{slug}/{bucket}/{id}/show", methods={"GET", "POST"}, name="doc_show")
     * 
     */ 
    public function docShow(Request $request, $slug, $bucket, DocUser $docUser, S3Client $S3Client)
    {

        #$bucket = '';
        $keyname =  'DOCS/user_docs/' ;
        $keyname .= $docUser->getName();
 
        $s3 = $S3Client;

        try {
            // Get the object.
            $result = $s3->getObject([
                'Bucket' => $bucket,
                'Key'    => $keyname
            ]);
        
            // Display the object in the browser.
            header("Content-Type: {$result['ContentType']}");
            echo $result['Body'];
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    
    }

}



