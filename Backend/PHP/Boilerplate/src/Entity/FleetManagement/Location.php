<?php

namespace App\Entity\FleetManagement;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FleetManagement\LocationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ApiResource]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $latitude = null;

    #[ORM\Column(length: 100)]
    private ?string $longitude  = null;

    #[ORM\OneToOne(mappedBy: 'location', cascade: ['persist', 'remove'])]
    private ?Vehicle $vehicle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): static
    {
        // unset the owning side of the relation if necessary
        if ($vehicle === null && $this->vehicle !== null) {
            $this->vehicle->setLocationId(null);
        }

        // set the owning side of the relation if necessary
        if ($vehicle !== null && $vehicle->getLocationId() !== $this) {
            $vehicle->setLocationId($this);
        }

        $this->vehicle = $vehicle;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }
}
