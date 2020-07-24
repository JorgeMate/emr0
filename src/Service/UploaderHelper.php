<?php

namespace App\Service;

use Gedmo\Sluggable\Util\Urlizer;

use League\Flysystem\FilesystemInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\AdapterInterface;

use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Context\RequestStackContext;
#use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symfony\Component\HttpFoundation\File\File;

class UploaderHelper
{

    const PATIENT_IMAGES = 'patient_imgs';

    private $filesystem;
    

    private $requestStackContext;

    private $logger;

    private $publicAssetBaseUrl;

    public function __construct(FilesystemInterface $uploadsFilesystem, RequestStackContext $requestStackContext, LoggerInterface $logger, string $uploadedAssetsBaseUrl)
    {

        $this->filesystem = $uploadsFilesystem;
    
        $this->requestStackContext = $requestStackContext;
        $this->logger = $logger;
        $this->publicAssetBaseUrl = $uploadedAssetsBaseUrl;

    }


    public function uploadPatientImage(File $file, ?string $existingFilename): string
    {


        $newFilename = $this->uploadFile($file, self::PATIENT_IMAGES, true);

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
        $fullPath = $this->publicAssetBaseUrl.'/'.$path;
        // if it's already absolute, just return
        if (strpos($fullPath, '://') !== false) {
            return $fullPath;
        }

        // needed if you deploy under a subdirectory
        return $this->requestStackContext
            ->getBasePath().$fullPath;

    }

    public function deleteFile(string $path)
    {
        $result = $this->filesystem->delete($path);

        if ($result === false) {
            throw new \Exception(sprintf('Error deleting "%s"', $path));
        }
    }


    /**
     * @return resource
     */
    public function readStream(string $path, bool $isPublic)
    {
        ///////////////////////////////////////////////////////////////////////
        $filesystem = $isPublic ? $this->filesystem : $this->privateFilesystem;

        $resource = $filesystem->readStream($path);

        if($resource === false){
            throw new \Exception(sprintf('Error opening stream for "%s"', $path));
        }
        return $resource;
    }






    public function uploadFile(File $file, string $directory, bool $isPublic): string
    {

        if ($file instanceof UploadedFile){
            $originalFilename = $file->getClientOriginalName();
        } else {
            $originalFilename = $file->getFilename();
        }
        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$file->guessExtension();

        ///////////////////////////////////////////////////////////////////////
        $filesystem = $isPublic ? $this->filesystem : $this->privateFilesystem;

        $stream = fopen($file->getPathname(), 'r');
        $result = $filesystem->writeStream(
            $directory. '/' .$newFilename,
            $stream,
            [
                'visibility' => $isPublic ? AdapterInterface::VISIBILITY_PUBLIC : AdapterInterface::VISIBILITY_PRIVATE
            ]
        );

        if ($result === false){
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }

        if(is_resource($stream)){
            fclose($stream);
        }

        return $newFilename;

    }


}
