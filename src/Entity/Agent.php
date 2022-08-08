<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgentRepository::class)]
class Agent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDay = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $nationality = null;

    #[ORM\ManyToMany(targetEntity: Speciality::class, inversedBy: 'agent')]
    private Collection $agentSpeciality;

    #[ORM\ManyToMany(targetEntity: Mission::class, inversedBy: 'agent')]
    private Collection $agentMission;

    public function __construct()
    {
        $this->agentSpeciality = new ArrayCollection();
        $this->agentMission = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

        return $this;
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

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * @return Collection<int, Speciality>
     */
    public function getAgentSpeciality(): Collection
    {
        return $this->agentSpeciality;
    }

    public function addAgentSpeciality(Speciality $agentSpeciality): self
    {
        if (!$this->agentSpeciality->contains($agentSpeciality)) {
            $this->agentSpeciality->add($agentSpeciality);
        }

        return $this;
    }

    public function removeAgentSpeciality(Speciality $agentSpeciality): self
    {
        $this->agentSpeciality->removeElement($agentSpeciality);

        return $this;
    }

    /**
     * @return Collection<int, Mission>
     */
    public function getAgentMission(): Collection
    {
        return $this->agentMission;
    }

    public function addAgentMission(Mission $agentMission): self
    {
        if (!$this->agentMission->contains($agentMission)) {
            $this->agentMission->add($agentMission);
        }

        return $this;
    }

    public function removeAgentMission(Mission $agentMission): self
    {
        $this->agentMission->removeElement($agentMission);

        return $this;
    }
}
