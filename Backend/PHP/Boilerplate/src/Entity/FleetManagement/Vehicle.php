<?php

namespace App\Entity\FleetManagement;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FleetManagement\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[ApiResource]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'vehicle', cascade: ['persist', 'remove'])]
    private ?Location $location = null;

    #[ORM\ManyToMany(targetEntity: Fleet::class, mappedBy: 'vehicles')]
    private Collection $fleets;

    #[ORM\Column(length: 100)]
    private ?string $plate_number = null;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): static
    {
        $this->location = $location;

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
            $fleet->addVehicle($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): static
    {
        if ($this->fleets->removeElement($fleet)) {
            $fleet->removeVehicle($this);
        }

        return $this;
    }

    public function getPlateNumber(): ?string
    {
        return $this->plate_number;
    }

    public function setPlateNumber(string $plate_number): static
    {
        $this->plate_number = $plate_number;

        return $this;
    }

    /**
     * Park the Vehicle to a Location. Returns true if succesfully parked, false otherwise.
     *
     * @param  Location $location the Location where to park the vehicle
     * @return bool true if succesfully parked, false otherwise
     */
    public function parkTo(Location $location): bool
    {
        if ($this->location == $location) {
            return false;
        } else {
            $this->setLocation($location);
            return true;
        }
    }

    /**
     * Alias of getLocation
     *
     * @return Location
     */
    public function localize(): Location
    {
        return $this->getLocation();
    }
}
