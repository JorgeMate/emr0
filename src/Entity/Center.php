<?php

namespace App\Entity;

use App\Repository\CenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=CenterRepository::class)
 */
class Center
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contact_person;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=31, nullable=true)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="center")
     */
    private $users;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"}) 
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $ssaas_account_name;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $ssaas_api_key;

    /**
     * @ORM\OneToMany(targetEntity=DocCenterGroup::class, mappedBy="center")
     */
    private $docCenterGroups;

    /**
     * @ORM\OneToMany(targetEntity=Insurance::class, mappedBy="center")
     */
    private $insurances;

    /**
     * @ORM\OneToMany(targetEntity=Source::class, mappedBy="center")
     */
    private $sources;

    /**
     * @ORM\OneToMany(targetEntity=Type::class, mappedBy="center", orphanRemoval=true)
     */
    private $types;

    /**
     * @ORM\OneToMany(targetEntity=Place::class, mappedBy="center", orphanRemoval=true)
     */
    private $places;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->docCenterGroups = new ArrayCollection();
        $this->insurances = new ArrayCollection();
        $this->sources = new ArrayCollection();
        $this->types = new ArrayCollection();
        $this->places = new ArrayCollection();
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

    public function getContactPerson(): ?string
    {
        return $this->contact_person;
    }

    public function setContactPerson(?string $contact_person): self
    {
        $this->contact_person = $contact_person;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(?string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCenter($this);
        }

        return $this;
    }

    // Ojo !
    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getCenter() === $this) {
                $user->setCenter(null);
            }
        }

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }




    public function getPatientsNo() 
    {
        $patientsNo = 0;
        foreach ($this->users as $user) {
            $patientsNo += $user->getPatients()->count();
        }
        return $patientsNo;
    }

    public function getSsaasAccountName(): ?string
    {
        return $this->ssaas_account_name;
    }

    public function setSsaasAccountName(?string $ssaas_account_name): self
    {
        $this->ssaas_account_name = $ssaas_account_name;

        return $this;
    }

    public function getSsaasApiKey(): ?string
    {
        return $this->ssaas_api_key;
    }

    public function setSsaasApiKey(?string $ssaas_api_key): self
    {
        $this->ssaas_api_key = $ssaas_api_key;

        return $this;
    }

    /**
     * @return Collection|DocCenterGroup[]
     */
    public function getDocCenterGroups(): Collection
    {
        return $this->docCenterGroups;
    }

    public function addDocCenterGroup(DocCenterGroup $docCenterGroup): self
    {
        if (!$this->docCenterGroups->contains($docCenterGroup)) {
            $this->docCenterGroups[] = $docCenterGroup;
            $docCenterGroup->setCenter($this);
        }

        return $this;
    }

    public function removeDocCenterGroup(DocCenterGroup $docCenterGroup): self
    {
        if ($this->docCenterGroups->contains($docCenterGroup)) {
            $this->docCenterGroups->removeElement($docCenterGroup);
            // set the owning side to null (unless already changed)
            if ($docCenterGroup->getCenter() === $this) {
                $docCenterGroup->setCenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Insurance[]
     */
    public function getInsurances(): Collection
    {
        return $this->insurances;
    }

    public function addInsurance(Insurance $insurance): self
    {
        if (!$this->insurances->contains($insurance)) {
            $this->insurances[] = $insurance;
            $insurance->setCenter($this);
        }

        return $this;
    }

    public function removeInsurance(Insurance $insurance): self
    {
        if ($this->insurances->contains($insurance)) {
            $this->insurances->removeElement($insurance);
            // set the owning side to null (unless already changed)
            if ($insurance->getCenter() === $this) {
                $insurance->setCenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Source[]
     */
    public function getSources(): Collection
    {
        return $this->sources;
    }

    public function addSource(Source $source): self
    {
        if (!$this->sources->contains($source)) {
            $this->sources[] = $source;
            $source->setCenter($this);
        }

        return $this;
    }

    public function removeSource(Source $source): self
    {
        if ($this->sources->contains($source)) {
            $this->sources->removeElement($source);
            // set the owning side to null (unless already changed)
            if ($source->getCenter() === $this) {
                $source->setCenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Type[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(Type $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setCenter($this);
        }

        return $this;
    }

    public function removeType(Type $type): self
    {
        if ($this->types->contains($type)) {
            $this->types->removeElement($type);
            // set the owning side to null (unless already changed)
            if ($type->getCenter() === $this) {
                $type->setCenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlaces(): Collection
    {
        return $this->places;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->places->contains($place)) {
            $this->places[] = $place;
            $place->setCenter($this);
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        if ($this->places->contains($place)) {
            $this->places->removeElement($place);
            // set the owning side to null (unless already changed)
            if ($place->getCenter() === $this) {
                $place->setCenter(null);
            }
        }

        return $this;
    } 



}
