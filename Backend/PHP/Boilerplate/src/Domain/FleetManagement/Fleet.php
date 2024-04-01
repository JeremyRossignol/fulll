<?php

declare(strict_types=1);

namespace Fulll\Domain\FleetManagement;

/**
 * The Fleet of Vehicles of an User
 *
 * @author Jérémy Rossignol [2024-03-25 12:05]
 */
class Fleet
{
   /**
    * The owner of the Fleet
    *
    * @var User
    */
   private User $user;
   /**
    * The list of Vehicles of the Fleet
    *
    * @var Vehicle[]
    */
   private array $vehicles = [];

   /**
    * Creates the Fleet of Vehicles of the User
    *
    * @param  User $user The User that owns the Fleet
    */
   public function __construct(User $user)
   {
      $this->user = $user;
   }

   /**
    * Get the User (owner) of the Fleet
    *
    * @return User
    */
   public function getUser(): User
   {
      return $this->user;
   }

   /**
    * Add a Vehicle to this fleet
    *
    * @param  Vehicle $vehicle the Vehicle to add
    * @return void
    */
   private function addVehicle(Vehicle $vehicle): void
   {
      $this->vehicles[] = $vehicle;
   }

   /**
    * Check if the Vehicle already exists in the Fleet
    *
    * @param  Vehicle $vehicle the Vehicle to check
    * @return boolean true if it exists, false otherwise
    */
   public function hasVehicle(Vehicle $vehicle): bool
   {
      return in_array($vehicle, $this->vehicles, true);
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
}
