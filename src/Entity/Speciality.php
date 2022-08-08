<?php

namespace App\Entity;

use App\Repository\SpecialityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialityRepository::class)]
class Speciality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'speciality', targetEntity: Mission::class, orphanRemoval: true)]
    private Collection $mission;

    #[ORM\ManyToMany(targetEntity: Agent::class, mappedBy: 'agentSpeciality')]
    private Collection $agent;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
        $this->agent = new ArrayCollection();
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

    /**
     * @return Collection<int, Mission>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setSpeciality($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getSpeciality() === $this) {
                $mission->setSpeciality(null);
            }
        }

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
            $agent->addAgentSpeciality($this);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agent->removeElement($agent)) {
            $agent->removeAgentSpeciality($this);
        }

        return $this;
    }
}
