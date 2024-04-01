<?php

declare(strict_types=1);

namespace Fulll\Domain\FleetManagement;

/**
 * A vehicle
 *
 * @author Jérémy Rossignol [2024-03-25 12:09]
 */
class Vehicle
{
   /**
    * Id of the Vehicle
    *
    * @var integer
    */
   private int $id;
   /**
    * The Location of the Vehicle
    *
    * @var Location|null
    */
   private ?Location $location = null;

   /**
    * Constructs the Vehicle
    *
    * @param  integer $id The id of the Vehicle
    */
   public function __construct(int $id)
   {
      $this->id = $id;
   }

   /**
    * Get the id of the Vehicle
    *
    * @return integer the id of the Vehicle
    */
   public function getId(): int
   {
      return $this->id;
   }

   /**
    * Set the location of the Vehicle
    *
    * @param  Location $location The Location of the Vehicle
    * @return void
    */
   private function setLocation(Location $location): void
   {
      $this->location = $location;
   }

   /**
    * Get the Location of the Vehicle
    *
    * @return Location|null The Location of the Vehicle
    */
   public function getLocation(): ?Location
   {
      return $this->location;
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
}
