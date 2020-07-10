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
    private $docsUser;

    public function __construct()
    {
        $this->docsUser = new ArrayCollection();
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
    public function getDocsUser(): Collection
    {
        return $this->docsUser;
    }

    public function addDocsUser(DocUser $docsUser): self
    {
        if (!$this->docsUser->contains($docsUser)) {
            $this->docsUser[] = $docsUser;
            $docsUser->setDocCenterGroup($this);
        }

        return $this;
    }

    public function removeDocsUser(DocUser $docsUser): self
    {
        if ($this->docsUser->contains($docsUser)) {
            $this->docsUser->removeElement($docsUser);
            // set the owning side to null (unless already changed)
            if ($docsUser->getDocCenterGroup() === $this) {
                $docsUser->setDocCenterGroup(null);
            }
        }

        return $this;
    }
}
