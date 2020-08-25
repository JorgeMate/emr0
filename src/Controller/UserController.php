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

use Doctrine\ORM\EntityManagerInterface;

use App\Form\DocUserType;

use App\Entity\Treatment;
use App\Entity\Opera;

use App\Entity\DocCenterGroup;
use App\Entity\DocUser;

use App\Entity\DocPatient;
use App\Entity\DocImgPatient;



use App\Service\UploaderHelper;


use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
#use Symfony\Component\HttpFoundation\StreamedResponse;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use SuperSaaS\Client;

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
    public function userCpanel(): Response
    {
        $user = $this->getUser();
        $center = $this->getUser()->getCenter();
        $groups = $center->getDocCenterGroups();

        $client = null;
        $agendas = null;
        $checksum = null;

        $ac_name = null;
        $api_key = null;

        if($center->getSsaasAccountName() && $center->getSsaasApiKey()){

            $ac_name = $center->getSsaasAccountName();
            $api_key = $center->getSsaasApiKey();

            $client = new Client();
            $client->account_name = $ac_name;
            $client->api_key = $api_key;

            try {
                $agendas = $client->schedules->getList();
                //var_dump($agendas);die;
            } catch (\Exception $e){

            }

            $checksum = md5($ac_name . $api_key . $user->getEmail());
            //var_dump($checksum);die;
        }

        return $this->render('user/cpanel.html.twig', [

            'user' => $user,
            'center' => $center,
            'groups' => $groups,

            'checksum' => $checksum,
            'ac_name' => $ac_name,
            'api_key' => $api_key,

            'agendas' => $agendas,
        ]);
    }

    /**
     * @Route("/profile/edit", methods={"GET", "POST"}, name="profile_edit")
     * @param Request $request
     * @return Response
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
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


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     * @Route("/{slug}/documents-groups", methods={"GET", "POST"}, name="doc_groups_index")
     * @param Request $request
     * @param $slug
     * @return Response
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
     * @param Request $request
     * @param $slug
     * @param DocCenterGroup $docCenterGroup
     * @param UploaderHelper $uploaderHelper
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function docsIndex(Request $request, $slug, DocCenterGroup $docCenterGroup, UploaderHelper $uploaderHelper)
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

            #dd($formDoc['docFile']->getData());

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $formDoc['docFile']->getData();

            if ($uploadedFile){

                $newFilename = $uploaderHelper->uploadUserDoc($uploadedFile, $newDoc->getName());

                $newDoc->setName($newFilename);
                $newDoc->setOriginalFilename($uploadedFile->getClientOriginalName());
                $newDoc->setMimeType($uploadedFile->getMimeType() ?? 'application/octet-stream');
                $newDoc->setDocSize($uploadedFile->getSize() ?? '0');

                $em->persist($newDoc);
                $em->flush();        
                $this->addFlash('info', 'doc.up_suc');
            }

            return $this->redirectToRoute('docs_index', ['slug' => $slug, 'id' => $docCenterGroup->getId() ] );


        }


        return $this->render('center/doc_groups/doc_index.html.twig', [
             
            'docCenterGroup' => $docCenterGroup,
            'docs' => $docs,
            'form' => $formDoc->createView(),
        ]);     

    }

    /**
     * @Route("/{slug}/{bucket}/{id}/user-doc", methods={"GET", "POST"}, name="doc_user_show")
     * @param Request $request
     * @param $slug
     * @param $bucket
     * @param DocUser $docUser
     * @param S3Client $S3Client
     */
    public function docUserShow(Request $request, $slug, $bucket, DocUser $docUser, S3Client $S3Client)
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

    /**
     * @Route("/{slug}/user-document/{id}", methods={"GET"}, name="doc_user_download")
     * @param DocUser $docUser
     * @param $slug
     * @param S3Client $s3Client
     * @param string $s3BucketName
     * @return RedirectResponse
     */
    public function downloadDocumentUser(DocUser $docUser, $slug,  S3Client $s3Client, string $s3BucketName)
    {
        $center = $docUser->getUser()->getCenter();
        $this->denyAccessUnlessGranted('CENTER_VIEW', $center);

        $disposition = HeaderUtils::makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $docUser->getOriginalFilename()
        );
        //::DISPOSITION_ATTACHMENT

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $s3BucketName,
            'Key' => $docUser->getFilePath(),
            'ResponseContentType' => $docUser->getMimeType(),
            'ResponseContentDisposition' => $disposition,
        ]);

        $request = $s3Client->createPresignedRequest($command, '+30 minutes');

        return new RedirectResponse((string) $request->getUri());


    }


    /**
     * @Route("/{slug}/patient-image/{id}", methods={"GET"}, name="img_patient_download")
     * @param DocImgPatient $docImgPatient
     * @param $slug
     * @param S3Client $s3Client
     * @param string $s3BucketName
     * @return RedirectResponse
     */
    public function downloadImagePat(DocImgPatient $docImgPatient, $slug,  S3Client $s3Client, string $s3BucketName)
    {
        $patient = $docImgPatient->getPatient();
        $this->denyAccessUnlessGranted('PATIENT_VIEW', $patient);

        $disposition = HeaderUtils::makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $docImgPatient->getOriginalFilename()
        );
        //::DISPOSITION_ATTACHMENT

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $s3BucketName,
            'Key' => $docImgPatient->getFilePath(),
            'ResponseContentType' => $docImgPatient->getMimeType(),
            'ResponseContentDisposition' => $disposition,
        ]);

        $request = $s3Client->createPresignedRequest($command, '+30 minutes');

        return new RedirectResponse((string) $request->getUri());
    }


    /**
     * @Route("/{slug}/patient-document/{id}", methods={"GET"}, name="doc_patient_download")
     * @param DocPatient $docPatient
     * @param $slug
     * @param S3Client $s3Client
     * @param string $s3BucketName
     * @return RedirectResponse
     */
    public function downloadDocumentPat(DocPatient $docPatient, $slug,  S3Client $s3Client, string $s3BucketName)
    {
        $patient = $docPatient->getPatient();
        $this->denyAccessUnlessGranted('PATIENT_VIEW', $patient);

        $disposition = HeaderUtils::makeDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $docPatient->getOriginalFilename()
        );
        //::DISPOSITION_ATTACHMENT

        $command = $s3Client->getCommand('GetObject', [
            'Bucket' => $s3BucketName,
            'Key' => $docPatient->getFilePath(),
            'ResponseContentType' => $docPatient->getMimeType(),
            'ResponseContentDisposition' => $disposition,
        ]);

        $request = $s3Client->createPresignedRequest($command, '+30 minutes');

        return new RedirectResponse((string) $request->getUri());
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    /**
     * @Route("/treatments", methods={"POST"}, name="treatments_get")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getTreatmentsFromTypeApi(Request $request, EntityManagerInterface $em)
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $typeId = $request->query->get('query');

        //$typeId = $type->getId();
        $results = [];
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(Treatment::class);
        $foundTreatments = $repository->findBy(['type' => $typeId], ['name' => 'ASC']);

        foreach ($foundTreatments as $treatment){

            $results[] = [
                'id' => $treatment->getId(),
                'name' => $treatment->getName(),
            ];

        }

        return $this->json($results);
    }

    /**
     * @Route("/img/{id}", methods={"DELETE"}, name="img_delete")
     * @param DocImgPatient $docImgPatient
     * @param UploaderHelper $uploaderHelper
     * @return Response
     * @throws \Exception
     */
    public function deleteImg(DocImgPatient $docImgPatient, UploaderHelper $uploaderHelper)
    {

        $uploaderHelper->deleteFile($docImgPatient->getFilePath());

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($docImgPatient);
        $em->flush();

        

        return new Response(null, 204);
    }

    /**
     * @Route("/doc/{id}", methods={"DELETE"}, name="doc_delete")
     * @param DocPatient $docPatient
     * @param UploaderHelper $uploaderHelper
     * @return Response
     * @throws \Exception
     */
    public function deleteDoc(DocPatient $docPatient, UploaderHelper $uploaderHelper)
    {

        $uploaderHelper->deleteFile($docPatient->getFilePath());

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($docPatient);
        $em->flush();



        return new Response(null, 204);
    }

    /**
     * @Route("/opera/{id}", methods={"DELETE"}, name="opera_delete")
     * @param Opera $opera
     * @return Response
     */
    public function deleteOpera(Opera $opera)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $em = $this->getDoctrine()->getManager();
        $em->remove($opera);
        $em->flush();
        return new Response(null, 204);
    }



}



