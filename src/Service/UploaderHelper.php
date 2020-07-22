<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{

    const PATIENT_IMAGES = '/patient_imgs';

    /**
     * var @var RequestStackContext
     */
    private $requestStackContext;

    public function __construct(string $uploadsPath, RequestStackContext $requestStackContext)
    {

        $this->uploadsPath = $uploadsPath;
        $this->requestStackContext = $requestStackContext;

    }


    public function uploadPatientImage(UploadedFile $uploadedFile): string
    {

        #$destination = $this->getParameter('kernel.project_dir').'/public/DOCS/patient_imgs';

        $destination = $this->uploadsPath . '/' . self::PATIENT_IMAGES;

        $originalFinalname = pathinfo($uploadedFile->getClientOriginalname(), PATHINFO_FILENAME);
        $newFilename = Urlizer::urlize($originalFinalname).'-'.uniqid().'.'. $uploadedFile->guessExtension();

        $uploadedFile->move(
            $destination,
            $newFilename
        );

        return $newFilename;
    }

    public function getPublicPath(string $path): string
    {

        return $this->requestStackContext
        ->getBasePath() . '/DOCS/' . $path;
    }
}
