<?php

namespace App\Entity\FleetManagement;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FleetManagement\FleetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FleetRepository::class)]
#[ApiResource]
class Fleet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'fleets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Vehicle::class, inversedBy: 'fleets')]
    private Collection $vehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        $this->vehicles->removeElement($vehicle);

        return $this;
    }

    /**
     * Check if the Vehicle already exists in the Fleet
     *
     * @param  Vehicle $vehicle the Vehicle to check
     * @return boolean true if it exists, false otherwise
     */
    public function hasVehicle(Vehicle $vehicle): bool
    {
        return $this->getVehicles()->contains($vehicle);
    }

    /**
     * Add the Vehicle into this Fleet if the Fleet doesn't already have the Vehicle
     *
     * @param  Vehicle $vehicle The Vehicle to add
     * @return boolean true if the vehicle was added, false otherwise
     */
    public function registerVehicle(Vehicle $vehicle): bool
    {
        if ($this->hasVehicle($vehicle)) {
            return false;
        } else {
            $this->addVehicle($vehicle);
            return true;
        }
    }

    /**
     * Get the location of the Vehicle
     *
     * @param  Vehicle $vehicle
     * @return Location the location of the vehicle
     */
    public function localizeVehicle(Vehicle $vehicle): Location
    {
        return $vehicle->localize();
    }

    /**
     * Park the Vehicle to a Location. Returns true if succesfully parked, false otherwise.
     *
     * @param  Vehicle $vehicle the Vehicle to park
     * @param  Location $location the Location where to park the vehicle
     * @return bool true if succesfully parked, false otherwise
     */
    public function parkVehicleTo(Vehicle $vehicle, Location $location): bool
    {
        return $vehicle->parkTo($location);
    }
}
