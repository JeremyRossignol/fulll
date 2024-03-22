<?php

declare(strict_types=1);

namespace Fulll\Domain;

class Fleet
{
   private User $user;
   private array $vehicles = [];

   public function __construct(User $user)
   {
      $this->user = $user;
   }

   public function addUser(User $user): void
   {
      $this->user = $user;
   }

   public function getUser(): User
   {
      return $this->user;
   }

   public function addVehicle(Vehicle $vehicle): void
   {
      $this->vehicles[] = $vehicle;
   }

   public function hasVehicle(Vehicle $vehicle): bool
   {
      return in_array($vehicle, $this->vehicles, true);
   }

   public function registerVehicle(Vehicle $vehicle): string
   {
      if ($this->hasVehicle($vehicle)) {
         return "This vehicle has already been registered into the fleet.";
      } else {
         $this->addVehicle($vehicle);
         return "Vehicle successfully registered into the fleet.";
      }
   }
}
