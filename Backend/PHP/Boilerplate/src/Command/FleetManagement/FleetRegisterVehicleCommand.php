<?php

namespace App\Command\FleetManagement;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\FleetManagement\Fleet;
use App\Entity\FleetManagement\Vehicle;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
   name: 'fleet:register-vehicle',
   description: 'register a vehicle into a fleet',
)]
class FleetRegisterVehicleCommand extends Command
{
   private $entityManager;

   public function __construct(EntityManagerInterface $entityManager)
   {
      $this->entityManager = $entityManager;
      parent::__construct();
   }

   protected function configure(): void
   {
      $this
         ->addArgument('fleetId', InputArgument::REQUIRED, 'The id of the fleet to register the vehicle')
         ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The plate number of the vehicle to register')
         //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
      ;
   }

   protected function execute(InputInterface $input, OutputInterface $output): int
   {
      $io = new SymfonyStyle($input, $output);
      $fleet_id = intval($input->getArgument('fleetId'));
      $vehicle_plate_number = $input->getArgument('vehiclePlateNumber');

      if ($fleet_id && $vehicle_plate_number) {
         try {
            $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleet_id);
            if ($fleet) {
               $vehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy(['plate_number' => $vehicle_plate_number]);
               if ($vehicle) {
                  if ($fleet->registerVehicle($vehicle)) {
                     $this->entityManager->persist($fleet);
                     $this->entityManager->flush();
                     $io->success('vehicle registered');
                  } else {
                     $io->error('Vehicule already registered');
                     return Command::FAILURE;
                  }
               } else {
                  $io->error('Vehicle not found');
                  return Command::FAILURE;
               }
            } else {
               $io->error('Fleet not found');
               return Command::FAILURE;
            }
         } catch (\Throwable $th) {
            $io->error($th->getMessage());
            return Command::FAILURE;
         }
      } else {
         $io->error('Missing arguments');
         return Command::FAILURE;
      }

      return Command::SUCCESS;
   }
}
