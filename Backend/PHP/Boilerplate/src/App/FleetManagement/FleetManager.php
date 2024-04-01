<?php

declare(strict_types=1);

namespace Fulll\App\FleetManagement;

use Fulll\Domain\FleetManagement\{
   Fleet,
   Vehicle,
   User,
   Location,
};

/**
 * Manages the fleet actions
 *
 * @author Jérémy Rossignol [2024-03-25 12:08]
 */
class FleetManager
{
   /**
    * Register a Vehicle and return a message whether the registration failed or succeed
    *
    * @param Vehicle $vehicle The Vehicle to register
    * @param Fleet $fleet The Fleet where the Vehicle will be registered
    * @return string The message of success or failure  
    */
   public static function registerVehicleInto(Vehicle $vehicle, Fleet $fleet): string
   {
      if ($fleet->registerVehicle($vehicle)) {
         return "Vehicle succesfully registered !";
      } else {
         return "Can't register vehicle. Vehicle already exists in fleet.";
      }
   }

   /**
    * Park a Vehicle and return a message whether the parking failed or succeed
    *
    * @param  Vehicle  $vehicle the Vehicle to park
    * @param  Location $location the Location where the Vehicle will be parked
    * @return string The message of success or failure
    */
   public static function parkVehicleTo(Vehicle $vehicle, Location $location): string
   {
      if ($vehicle->parkTo($location)) {
         return "Vehicle sucessfully parked !";
      } else {
         return "Can't park vehicle. Vehicle already parked here.";
      }
   }
}
