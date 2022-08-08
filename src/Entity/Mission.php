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

    #[ORM\ManyToOne(inversedBy: 'mission')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Speciality $speciality = null;

    #[ORM\ManyToMany(targetEntity: Agent::class, mappedBy: 'agentMission')]
    private Collection $agent;

    #[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: 'contactMission')]
    private Collection $contact;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Target::class, orphanRemoval: true)]
    private Collection $target;

    #[ORM\OneToMany(mappedBy: 'mission', targetEntity: Planque::class, orphanRemoval: true)]
    private Collection $planque;

    public function __construct()
    {
        $this->agent = new ArrayCollection();
        $this->contact = new ArrayCollection();
        $this->target = new ArrayCollection();
        $this->planque = new ArrayCollection();
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
     * @return Collection<int, Agent>
     */
    public function getAgent(): Collection
    {
        return $this->agent;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agent->contains($agent)) {
            $this->agent->add($agent);
            $agent->addAgentMission($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agent->removeElement($agent)) {
            $agent->removeAgentMission($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContact(): Collection
    {
        return $this->contact;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contact->contains($contact)) {
            $this->contact->add($contact);
            $contact->addContactMission($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contact->removeElement($contact)) {
            $contact->removeContactMission($this);
        }

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
}
