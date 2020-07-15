<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Gedmo\Sluggable\Util\Urlizer;


/**
 * Controller used to manage current user.
 *
 * @Route("/user")
 * @Security("is_granted('ROLE_USER')")
 *
 */
class UploadsController extends AbstractController
{
    /**
     * @Route("/upload/test", name="upload_test")
     */
    public function temporaryloadAction(Request $request)
    {

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = ($request->files->get('image'));
        $destination = $this->getParameter('kernel.project_dir').'/public/DOCS/patient_imgs';

        $originalFinalname = pathinfo($uploadedFile->getClientOriginalname(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFinalname.'-'.uniqid().'.'. $uploadedFile->guessExtension());

        dd($uploadedFile->move(
            $destination,
            $newFilename
        ));
    }
}
