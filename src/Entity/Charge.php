<?php

namespace App\Entity;

use App\Repository\ChargeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChargeRepository::class)
 */
class Charge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Opera::class, inversedBy="charges")
     */
    private $opera;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     */
    private $issued;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $paid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpera(): ?Opera
    {
        return $this->opera;
    }

    public function setOpera(?Opera $opera): self
    {
        $this->opera = $opera;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIssued(): ?\DateTimeInterface
    {
        return $this->issued;
    }

    public function setIssued(\DateTimeInterface $issued): self
    {
        $this->issued = $issued;

        return $this;
    }

    public function getPaid(): ?\DateTimeInterface
    {
        return $this->paid;
    }

    public function setPaid(?\DateTimeInterface $paid): self
    {
        $this->paid = $paid;

        return $this;
    }
}
