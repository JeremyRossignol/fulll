<?php

declare(strict_types=1);

namespace Fulll\Domain\FleetManagement;

/**
 * Class User 
 *
 * @author Jérémy Rossignol [2024-03-25 12:07]
 */
class User
{
   /**
    * The name of the User
    *
    * @var string
    */
   private string $name;

   /**
    * Construct the User with a name
    *
    * @param  string $name The User name
    */
   public function __construct(string $name)
   {
      $this->name = $name;
   }

   /**
    * Get the name of the User
    *
    * @return string the name of the User
    */
   public function getName(): string
   {
      return $this->name;
   }
}
