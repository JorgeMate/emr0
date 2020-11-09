<?php

namespace App\Entity;

use App\Repository\ReportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportRepository::class)
 */
class Report
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ReportType::class, inversedBy="reports")
     */
    private $report_type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="reports")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=ReportPart::class, mappedBy="report", orphanRemoval=true)
     */
    private $reportParts;

    public function __construct()
    {
        $this->reportParts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReportType(): ?ReportType
    {
        return $this->report_type;
    }

    public function setReportType(?ReportType $report_type): self
    {
        $this->report_type = $report_type;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|ReportPart[]
     */
    public function getReportParts(): Collection
    {
        return $this->reportParts;
    }

    public function addReportPart(ReportPart $reportPart): self
    {
        if (!$this->reportParts->contains($reportPart)) {
            $this->reportParts[] = $reportPart;
            $reportPart->setReport($this);
        }

        return $this;
    }

    public function removeReportPart(ReportPart $reportPart): self
    {
        if ($this->reportParts->contains($reportPart)) {
            $this->reportParts->removeElement($reportPart);
            // set the owning side to null (unless already changed)
            if ($reportPart->getReport() === $this) {
                $reportPart->setReport(null);
            }
        }

        return $this;
    }
}
