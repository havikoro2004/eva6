<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MissionRepository::class)]
class Mission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'mission')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MissionType $type = null;

    #[ORM\ManyToOne(inversedBy: 'mission')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MissionStatus $status = null;

    #[ORM\ManyToMany(targetEntity: Agent::class, inversedBy: 'missions')]
    private Collection $agentMission;

    #[ORM\ManyToMany(targetEntity: Contact::class, inversedBy: 'missions')]
    private Collection $contactMission;

    #[ORM\ManyToMany(targetEntity: Target::class, inversedBy: 'missions')]
    private Collection $targetMission;

    #[ORM\ManyToMany(targetEntity: Planque::class, inversedBy: 'missions')]
    private Collection $planqueMission;

    public function __construct()
    {

        $this->target = new ArrayCollection();
        $this->planque = new ArrayCollection();
        $this->agentMission = new ArrayCollection();
        $this->contactMission = new ArrayCollection();
        $this->targetMission = new ArrayCollection();
        $this->planqueMission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getType(): ?MissionType
    {
        return $this->type;
    }

    public function setType(?MissionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?MissionStatus
    {
        return $this->status;
    }

    public function setStatus(?MissionStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getSpeciality(): ?Speciality
    {
        return $this->speciality;
    }

    public function setSpeciality(?Speciality $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }


    /**
     * @return Collection<int, Target>
     */
    public function getTarget(): Collection
    {
        return $this->target;
    }

    public function addTarget(Target $target): self
    {
        if (!$this->target->contains($target)) {
            $this->target->add($target);
            $target->setMission($this);
        }

        return $this;
    }

    public function removeTarget(Target $target): self
    {
        if ($this->target->removeElement($target)) {
            // set the owning side to null (unless already changed)
            if ($target->getMission() === $this) {
                $target->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planque>
     */
    public function getPlanque(): Collection
    {
        return $this->planque;
    }

    public function addPlanque(Planque $planque): self
    {
        if (!$this->planque->contains($planque)) {
            $this->planque->add($planque);
            $planque->setMission($this);
        }

        return $this;
    }

    public function removePlanque(Planque $planque): self
    {
        if ($this->planque->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getMission() === $this) {
                $planque->setMission(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgentMission(): Collection
    {
        return $this->agentMission;
    }

    public function addAgentMission(Agent $agentMission): self
    {
        if (!$this->agentMission->contains($agentMission)) {
            $this->agentMission->add($agentMission);
        }

        return $this;
    }

    public function removeAgentMission(Agent $agentMission): self
    {
        $this->agentMission->removeElement($agentMission);

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContactMission(): Collection
    {
        return $this->contactMission;
    }

    public function addContactMission(Contact $contactMission): self
    {
        if (!$this->contactMission->contains($contactMission)) {
            $this->contactMission->add($contactMission);
        }

        return $this;
    }

    public function removeContactMission(Contact $contactMission): self
    {
        $this->contactMission->removeElement($contactMission);

        return $this;
    }

    /**
     * @return Collection<int, Target>
     */
    public function getTargetMission(): Collection
    {
        return $this->targetMission;
    }

    public function addTargetMission(Target $targetMission): self
    {
        if (!$this->targetMission->contains($targetMission)) {
            $this->targetMission->add($targetMission);
        }

        return $this;
    }

    public function removeTargetMission(Target $targetMission): self
    {
        $this->targetMission->removeElement($targetMission);

        return $this;
    }

    /**
     * @return Collection<int, Planque>
     */
    public function getPlanqueMission(): Collection
    {
        return $this->planqueMission;
    }

    public function addPlanqueMission(Planque $planqueMission): self
    {
        if (!$this->planqueMission->contains($planqueMission)) {
            $this->planqueMission->add($planqueMission);
        }

        return $this;
    }

    public function removePlanqueMission(Planque $planqueMission): self
    {
        $this->planqueMission->removeElement($planqueMission);

        return $this;
    }
}
