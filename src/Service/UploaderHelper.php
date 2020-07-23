<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\File\File;

class UploaderHelper
{

    const PATIENT_IMAGES = '/patient_imgs';

    private $filesystem;

    private $requestStackContext;

    private $logger;

    private $publicAssetBaseUrl;

    public function __construct(FilesystemInterface $publicUploadsFilesystem, RequestStackContext $requestStackContext, LoggerInterface $logger, string $uploadedAssetsBaseUrl)
    {

        $this->filesystem = $publicUploadsFilesystem;
        $this->requestStackContext = $requestStackContext;
        $this->logger = $logger;
        $this->publicAssetBaseUrl = $uploadedAssetsBaseUrl;

    }


    public function uploadPatientImage(File $file, ?string $existingFilename): string
    {

        #$destination = $this->getParameter('kernel.project_dir').'/public/DOCS/patient_imgs';

        #$destination = $this->uploadsPath . '/' . self::PATIENT_IMAGES;

        if ($file instanceof UploadedFile){

            $originalFilename = $file->getClientOriginalName();

        } else {

            $originalFilename = $file->getFilename();

        }

        #$originalFinalname = pathinfo($uploadedFile->getClientOriginalname(), PATHINFO_FILENAME);
        #$newFilename = Urlizer::urlize($originalFinalname).'-'.uniqid().'.'. $uploadedFile->guessExtension();

        //  $uploadedFile->move(
        //      $destination,
        //      $newFilename
        //  );


        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();

        #$newFilename = $this->uploadFile($file, self::PATIENT_IMAGES, true);

        $stream = fopen($file->getPathname(), 'r');

    

        $result = $this->filesystem->writeStream(
            self::PATIENT_IMAGES. '/' .$newFilename,
            $stream
        );

        if ($result === false){
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }

        if(is_resource($stream)){
            fclose($stream);
        }

        if($existingFilename){
            try {
                $result = $this->filesystem->delete(self::PATIENT_IMAGES. '/' .$existingFilename);

                if ($result === false){
                    throw new \Exception(sprintf('Could not delete old uploaded file "%s"', $newFilename));
                }

            } catch (FileNotFoundException $e) {
                $this->logger->alert(sprintf('Old uploaded file "%s" was missing when trying to delete', $existingFilename));
            }
        }

        return $newFilename;
    }

    public function getPublicPath(string $path): string
    {

        return $this->requestStackContext
        ->getBasePath() . $this->publicAssetBaseUrl .  $path;
    }
}
