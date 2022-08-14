<?php

namespace App\Entity;

use App\Repository\MissionStatusRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MissionStatusRepository::class)]
class MissionStatus
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

    #[ORM\OneToMany(mappedBy: 'status', targetEntity: Mission::class)]
    private Collection $mission;

    /**
     * @return Collection
     */
    public function getMission(): Collection
    {
        return $this->mission;
    }

    /**
     * @param Collection $mission
     */
    public function setMission(Collection $mission): void
    {
        $this->mission = $mission;
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

    public function __toString(): string
    {
        return $this->getName();
    }

}
