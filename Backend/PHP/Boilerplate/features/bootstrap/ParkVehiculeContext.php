<?php

use Behat\Behat\Context\Context;

use Fulll\App\FleetManager;

use Fulll\Domain\{
   Fleet,
   Vehicle,
   User,
};


class FleetContext implements Context
{
   private User $user;
   private User $anotherUser;
   private Fleet $fleet;
   private Fleet $anotherUserFleet;
   private Vehicle $vehicle;
   private string $registrationStatus;

   /**
    * @Given a user named :username
    */
   public function aUserNamed($username): void
   {
      $this->user = new User($username);
   }

   /**
    * @Given the fleet of the user
    */
   public function theFleetOfTheUser(): void
   {
      $this->fleet = new Fleet($this->user);
   }

   /**
    * @When I register a vehicle
    */
   public function iRegisterAVehicle(): void
   {
      $this->vehicle = new Vehicle(1); // Assuming ID 1 for simplicity
      $fleetManager = new FleetManager();
      $this->registrationStatus = $fleetManager->registerVehicle($this->vehicle, $this->fleet);
   }

   /**
    * @Then the vehicle should be part of the fleet
    */
   public function theVehicleShouldBePartOfTheFleet(): void
   {
      if (!$this->fleet->hasVehicle($this->vehicle)) {
         throw new \Exception("Vehicle is not part of the fleet.");
      }
   }

   /**
    * @Given a vehicle has already been registered into the fleet
    */
   public function aVehicleHasAlreadyBeenRegisteredIntoTheFleet(): void
   {
      $this->vehicle = new Vehicle(1); // Assuming ID 1 for simplicity
      $this->fleet->addVehicle($this->vehicle);
   }

   /**
    * @When I try to register the same vehicle into the fleet
    */
   public function iTryToRegisterTheSameVehicleIntoTheFleet(): void
   {
      $fleetManager = new FleetManager();
      $this->registrationStatus = $fleetManager->registerVehicle($this->vehicle, $this->fleet);
   }

   /**
    * @Then I should be informed that the vehicle has already been registered into the fleet
    */
   public function iShouldBeInformedThatTheVehicleHasAlreadyBeenRegisteredIntoTheFleet(): void
   {
      if ($this->registrationStatus !== "This vehicle has already been registered into the fleet.") {
         throw new \Exception("Expected error message not received.");
      }
   }

   /**
    * @Given the fleet of another user
    */
   public function theFleetOfAnotherUser(): void
   {
      $this->anotherUser = new User("anotherUser");
      $this->anotherUserFleet = new Fleet($this->anotherUser);
   }

   /**
    * @When I register the same vehicle into the other user's fleet
    */
   public function iRegisterTheSameVehicleIntoTheOtherUsersFleet(): void
   {
      $this->fleet->registerVehicle($this->vehicle);
   }
}
