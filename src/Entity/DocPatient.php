<?php

namespace App\Entity;

use App\Repository\DocPatientRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Service\UploaderHelper;

use Symfony\Component\HttpFoundation\File\File;

use Gedmo\Mapping\Annotation as Gedmo;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @ORM\Entity(repositoryClass=DocPatientRepository::class)
 * 
 */
class DocPatient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="docPatients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $docSize;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $mime_type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;



    

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @var File
     */
    private $docFile;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=127)    
     * @Groups({"main", "input"})   
     */
    private $originalFilename;

# * @Assert\NotBlank() 
# * @Assert\Length(max=100)
# * 

   /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $docFile
     */

    public function setDocFile(?File $docFile = null): void
    {
        $this->docFile = $docFile;

        if (null !== $docFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated_at = new \DateTimeImmutable();
        }
    }

    public function getDocFile(): ?File
    {
        return $this->docFile;
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDocSize(): ?int
    {
        return $this->docSize;
    }

    public function setDocSize(int $docSize): self
    {
        $this->docSize = $docSize;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    public function setMimeType(string $mime_type): self
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(string $originalFilename): self
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }




    public function getFilePath()
    {
        return UploaderHelper::PATIENT_DOCS . '/' . $this->getName();
    }




}
