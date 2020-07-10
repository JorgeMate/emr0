<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $tel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=Center::class, inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $center;

    /**
     * @ORM\OneToMany(targetEntity=Patient::class, mappedBy="user")
     */
    private $patients;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $medic;

    /**
     * @ORM\Column(type="string", length=3, nullable=true)
     */
    private $cod;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=127, nullable=true)
     */
    private $speciality;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $internal;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $tax_code;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $reg_code1;

    /**
     * @ORM\Column(type="string", length=63, nullable=true)
     */
    private $reg_code2;

    /**
     * @ORM\OneToMany(targetEntity=DocUser::class, mappedBy="user")
     */
    private $docs;








    
    public function __construct()
    {
        $this->patients = new ArrayCollection();
        $this->docs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

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

    public function getCenter(): ?Center
    {
        return $this->center;
    }

    public function setCenter(?Center $center): self
    {
        $this->center = $center;

        return $this;
    }










    public function getAdmin(){

        if (in_array('ROLE_ADMIN', $this->getRoles()) 
                || in_array('ROLE_SUPER_ADMIN', $this->getRoles())) {
            return true;
        }
    }
    
    public function getCenterUser(){
        if ($this->getCenter()) {
            return ($this === $this->getCenter()->getUser());
        } else {
            return false;
        }
    }

    public function setAdmin(bool $admin)
    {
        if($admin || $this->getCenterUser()){
            if (!in_array('ROLE_SUPER_ADMIN', $this->getRoles())) {
                $this->setRoles(['ROLE_ADMIN']);
            }
            $this->setEnabled(true);
        } else {
            $this->setRoles([]);            
        }
        
        return $this;
    }

    public function setCenterUser(bool $update)
    {
        if($update) {
            $this->getCenter()->setUser($this);
            // Hacemos administrador a este usuario
            $this->setAdmin(true);
        } else {
            $this->getCenter()->setUser(null);
        }

        return $this;
        
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setUser($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->contains($patient)) {
            $this->patients->removeElement($patient);
            // set the owning side to null (unless already changed)
            if ($patient->getUser() === $this) {
                $patient->setUser(null);
            }
        }

        return $this;
    }

    public function getMedic(): ?bool
    {
        return $this->medic;
    }

    public function setMedic(?bool $medic): self
    {
        $this->medic = $medic;

        return $this;
    }

    public function getCod(): ?string
    {
        return $this->cod;
    }

    public function setCod(?string $cod): self
    {
        $this->cod = $cod;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function setSpeciality(?string $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getInternal(): ?bool
    {
        return $this->internal;
    }

    public function setInternal(?bool $internal): self
    {
        $this->internal = $internal;

        return $this;
    }

    public function getTaxCode(): ?string
    {
        return $this->tax_code;
    }

    public function setTaxCode(?string $tax_code): self
    {
        $this->tax_code = $tax_code;

        return $this;
    }

    public function getRegCode1(): ?string
    {
        return $this->reg_code1;
    }

    public function setRegCode1(?string $reg_code1): self
    {
        $this->reg_code1 = $reg_code1;

        return $this;
    }

    public function getRegCode2(): ?string
    {
        return $this->reg_code2;
    }

    public function setRegCode2(?string $reg_code2): self
    {
        $this->reg_code2 = $reg_code2;

        return $this;
    }

    /**
     * @return Collection|DocUser[]
     */
    public function getDocs(): Collection
    {
        return $this->docs;
    }

    public function addDoc(DocUser $doc): self
    {
        if (!$this->docs->contains($doc)) {
            $this->docs[] = $doc;
            $doc->setUser($this);
        }

        return $this;
    }

    public function removeDoc(DocUser $doc): self
    {
        if ($this->docs->contains($doc)) {
            $this->docs->removeElement($doc);
            // set the owning side to null (unless already changed)
            if ($doc->getUser() === $this) {
                $doc->setUser(null);
            }
        }

        return $this;
    }






}
