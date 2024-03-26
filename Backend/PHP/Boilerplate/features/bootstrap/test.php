<?php

declare(strict_types=1);
//require_once '/root/dev_projects/php/fulll/Backend/PHP/Boilerplate/vendor/autoload.php';

use Behat\Behat\Context\Context;

use Fulll\App\FleetManagement\FleetManager;

/*
use Fulll\Domain\FleetManagement\{
   Fleet,
   Vehicle,
   User,
   Location,
};*/

use Fulll\Domain\FleetManagement\Fleet;
use Fulll\Domain\FleetManagement\Vehicle;
use Fulll\Domain\FleetManagement\User;
use Fulll\Domain\FleetManagement\Location;

$fm = new FleetManager();
$u = new User("name");
