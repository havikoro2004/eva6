<?php

namespace App\Entity;

use App\Repository\PlanqueTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlanqueTypeRepository::class)]
class PlanqueType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Planque::class, orphanRemoval: true)]
    private Collection $planque;

    public function __construct()
    {
        $this->planque = new ArrayCollection();
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
    public function getPlanque(): Collection
    {
        return $this->planque;
    }

    public function addPlanque(Planque $planque): self
    {
        if (!$this->planque->contains($planque)) {
            $this->planque->add($planque);
            $planque->setType($this);
        }

        return $this;
    }

    public function removePlanque(Planque $planque): self
    {
        if ($this->planque->removeElement($planque)) {
            // set the owning side to null (unless already changed)
            if ($planque->getType() === $this) {
                $planque->setType(null);
            }
        }

        return $this;
    }
}
