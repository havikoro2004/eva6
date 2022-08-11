<?php

namespace App\Entity;

use App\Repository\PlanqueTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PlanqueTypeRepository::class)]
class PlanqueType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(max: 50)]
    #[Assert\Regex('/^\w+/')]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Planque::class)]
    private Collection $mission;

    public function __construct()
    {
        $this->mission = new ArrayCollection();
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
     * @return Collection<int, Planque>
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    public function addMission(Planque $mission): self
    {
        if (!$this->mission->contains($mission)) {
            $this->mission->add($mission);
            $mission->setType($this);
        }

        return $this;
    }

    public function removeMission(Planque $mission): self
    {
        if ($this->mission->removeElement($mission)) {
            // set the owning side to null (unless already changed)
            if ($mission->getType() === $this) {
                $mission->setType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
