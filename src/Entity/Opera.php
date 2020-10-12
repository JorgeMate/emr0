<?php

namespace App\Entity;

use App\Repository\OperaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=OperaRepository::class)
 */
class Opera
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="operas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Treatment::class, inversedBy="operas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $treatment;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $made_at;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="operas")
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="operas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="float", options={"default" : 0.0})
     */
    private $value;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity=Charge::class, mappedBy="opera")
     */
    private $charges;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $operateur;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $assistent;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $omloop;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $anesthesie;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $anesthesie_md;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $re_ok;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $complica;

    public function __construct()
    {
        $this->charges = new ArrayCollection();
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

    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(?Treatment $treatment): self
    {
        $this->treatment = $treatment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getMadeAt(): ?\DateTimeInterface
    {
        return $this->made_at;
    }

    public function setMadeAt(?\DateTimeInterface $made_at): self
    {
        $this->made_at = $made_at;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Collection|Charge[]
     */
    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charge $charge): self
    {
        if (!$this->charges->contains($charge)) {
            $this->charges[] = $charge;
            $charge->setOpera($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): self
    {
        if ($this->charges->contains($charge)) {
            $this->charges->removeElement($charge);
            // set the owning side to null (unless already changed)
            if ($charge->getOpera() === $this) {
                $charge->setOpera(null);
            }
        }

        return $this;
    }

    public function getOperateur(): ?string
    {
        return $this->operateur;
    }

    public function setOperateur(?string $operateur): self
    {
        $this->operateur = $operateur;

        return $this;
    }

    public function getAssistent(): ?string
    {
        return $this->assistent;
    }

    public function setAssistent(?string $assistent): self
    {
        $this->assistent = $assistent;

        return $this;
    }

    public function getOmloop(): ?string
    {
        return $this->omloop;
    }

    public function setOmloop(?string $omloop): self
    {
        $this->omloop = $omloop;

        return $this;
    }

    public function getAnesthesie(): ?string
    {
        return $this->anesthesie;
    }

    public function setAnesthesie(?string $anesthesie): self
    {
        $this->anesthesie = $anesthesie;

        return $this;
    }

    public function getAnesthesieMd(): ?string
    {
        return $this->anesthesie_md;
    }

    public function setAnesthesieMd(?string $anesthesie_md): self
    {
        $this->anesthesie_md = $anesthesie_md;

        return $this;
    }

    public function getReOk(): ?bool
    {
        return $this->re_ok;
    }

    public function setReOk(bool $re_ok): self
    {
        $this->re_ok = $re_ok;

        return $this;
    }

    public function getComplica(): ?bool
    {
        return $this->complica;
    }

    public function setComplica(bool $complica): self
    {
        $this->complica = $complica;

        return $this;
    }
}
