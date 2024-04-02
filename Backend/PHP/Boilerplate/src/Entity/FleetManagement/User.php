<?php

namespace App\Entity\FleetManagement;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FleetManagement\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;


    #[ORM\OneToMany(targetEntity: Fleet::class, mappedBy: 'user_id')]
    private Collection $fleets;

    public function __construct()
    {
        $this->fleets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Fleet>
     */
    public function getFleets(): Collection
    {
        return $this->fleets;
    }

    public function addFleet(Fleet $fleet): static
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets->add($fleet);
            $fleet->setUserId($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): static
    {
        if ($this->fleets->removeElement($fleet)) {
            // set the owning side to null (unless already changed)
            if ($fleet->getUserId() === $this) {
                $fleet->setUserId(null);
            }
        }

        return $this;
    }
}
