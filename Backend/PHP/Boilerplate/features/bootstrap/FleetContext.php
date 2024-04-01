<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\FleetManagement\FleetManager;
use Fulll\Domain\FleetManagement\{
   Fleet,
   Vehicle,
   User,
   Location,
};

class FleetContext implements Context
{
   protected User $me;
   protected User $someoneElse;
   protected Fleet $myFleet;
   protected Fleet $someoneElsesFleet;
   protected Vehicle $aVehicle;
   protected Location $aLocation;

   protected string $registrationStatus;
   protected string $parkingStatus;

   /**
    * @Given my fleet
    */
   public function myFleet()
   {
      $this->me = new User("me"); //assumed "me" for simplicity
      $this->myFleet = new Fleet($this->me);
   }

   /**
    * @Given a vehicle
    */
   public function aVehicle()
   {
      $this->aVehicle = new Vehicle(1); //assumed 1 for simplicity
   }

   /**
    * @Given I have registered this vehicle into my fleet
    */
   public function iHaveRegisteredThisVehicleIntoMyFleet()
   {
      if (!$this->myFleet->hasVehicle($this->aVehicle)) {
         FleetManager::registerVehicleInto($this->aVehicle, $this->myFleet);
      }
   }

   /**
    * @Given a location
    */
   public function aLocation()
   {
      $this->aLocation = new Location("43.4730119,5.5017451"); //assumed "43.4730119,5.5017451" for simplicity
   }

   /**
    * @When I park my vehicle at this location
    */
   public function iParkMyVehicleAtThisLocation()
   {
      FleetManager::parkVehicleTo($this->aVehicle, $this->aLocation);
   }

   /**
    * @Then the known location of my vehicle should verify this location
    */
   public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
   {
      if (!$this->aVehicle->getLocation() === $this->aLocation) {
         throw new \Exception("The known Location of this vehicle should verify this location");
      }
   }

   /**
    * @Given my vehicle has been parked into this location
    */
   public function myVehicleHasBeenParkedIntoThisLocation()
   {
      if ($this->aVehicle->getLocation() != $this->aLocation) {
         FleetManager::parkVehicleTo($this->aVehicle, $this->aLocation);
      }
   }

   /**
    * @When I try to park my vehicle at this location
    */
   public function iTryToParkMyVehicleAtThisLocation()
   {
      $this->parkingStatus = FleetManager::parkVehicleTo($this->aVehicle, $this->aLocation);
   }

   /**
    * @Then I should be informed that my vehicle is already parked at this location
    */
   public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
   {
      if ($this->parkingStatus !== "Can't park vehicle. Vehicle already parked here.") {
         throw new \Exception("Expected error message not received.");
      }
   }

   /**
    * @When I register this vehicle into my fleet
    */
   public function iRegisterThisVehicleIntoMyFleet()
   {
      $this->registrationStatus = FleetManager::registerVehicleInto($this->aVehicle, $this->myFleet);
   }

   /**
    * @Then this vehicle should be part of my vehicle fleet
    */
   public function thisVehicleShouldBePartOfMyVehicleFleet()
   {
      if ($this->myFleet->hasVehicle($this->aVehicle) === false) {
         throw new \Exception("This vehicle should be part of my vehicle fleet");
      }
   }

   /**
    * @When I try to register this vehicle into my fleet
    */
   public function iTryToRegisterThisVehicleIntoMyFleet()
   {
      $this->registrationStatus = FleetManager::registerVehicleInto($this->aVehicle, $this->myFleet);
   }

   /**
    * @Then I should be informed this this vehicle has already been registered into my fleet
    */
   public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
   {
      if ($this->registrationStatus !== "Can't register vehicle. Vehicle already exists in fleet.") {
         throw new \Exception("Expected error message not received.");
      }
   }

   /**
    * @Given the fleet of another user
    */
   public function theFleetOfAnotherUser()
   {
      $this->someoneElse = new User("someoneElse"); //assumed "someoneElse" for simplicity
      $this->someoneElsesFleet = new Fleet($this->someoneElse);
   }

   /**
    * @Given this vehicle has been registered into the other user's fleet
    */
   public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
   {
      if (!$this->someoneElsesFleet->hasVehicle($this->aVehicle)) {
         FleetManager::registerVehicleInto($this->aVehicle, $this->someoneElsesFleet);
      }
   }
}
