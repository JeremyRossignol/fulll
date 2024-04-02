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
use App\Entity\FleetManagement\Location;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'fleet:park-vehicle',
    description: 'park a vehicle of a fleet to a location',
)]
class FleetParkVehicleCommand extends Command
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
            ->addArgument('fleetId', InputArgument::REQUIRED, 'The id of the fleet of the vehicle')
            ->addArgument('vehiclePlateNumber', InputArgument::REQUIRED, 'The plate number of the vehicle to localize')
            ->addArgument('locationId', InputArgument::REQUIRED, 'The id of the location where to park the vehicle')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $fleet_id = intval($input->getArgument('fleetId'));
        $vehicle_plate_number = $input->getArgument('vehiclePlateNumber');
        $location_id = intval($input->getArgument('locationId'));

        if ($fleet_id && $vehicle_plate_number && $location_id) {
            try {
                $fleet = $this->entityManager->getRepository(Fleet::class)->find($fleet_id);
                if ($fleet) {
                    $vehicle = $this->entityManager->getRepository(Vehicle::class)->findOneBy(['plate_number' => $vehicle_plate_number]);
                    if ($vehicle) {
                        $location = $this->entityManager->getRepository(Location::class)->find($location_id);
                        if ($location) {
                            if ($fleet->parkVehicleTo($vehicle, $location)) {
                                $this->entityManager->persist($vehicle);
                                $this->entityManager->flush();
                                $io->success('Vehicle parked successfully');
                            } else {
                                $io->error('Vehicle already parked here');
                                return Command::FAILURE;
                            }
                        } else {
                            $io->error('Location not found');
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
