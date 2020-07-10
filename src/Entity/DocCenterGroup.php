<?php

namespace App\Entity;

use App\Repository\DocCenterGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocCenterGroupRepository::class)
 */
class DocCenterGroup
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Center::class, inversedBy="docCenterGroups")
     */
    private $center;

    /**
     * @ORM\OneToMany(targetEntity=DocUser::class, mappedBy="docCenterGroup")
     */
    private $docs;

    public function __construct()
    {
        $this->docs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCenter(): ?Center
    {
        return $this->center;
    }

    public function setCenter(?Center $center): self
    {
        $this->center = $center;

        return $this;
    }

    /**
     * @return Collection|DocUser[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDocs(DocUser $docsUser): self
    {
        if (!$this->docs->contains($docsUser)) {
            $this->docs[] = $docsUser;
            $docsUser->setDocCenterGroup($this);
        }

        return $this;
    }

    public function removeDocs(DocUser $docsUser): self
    {
        if ($this->docs->contains($docsUser)) {
            $this->docs->removeElement($docsUser);
            // set the owning side to null (unless already changed)
            if ($docsUser->getDocCenterGroup() === $this) {
                $docsUser->setDocCenterGroup(null);
            }
        }

        return $this;
    }
}
