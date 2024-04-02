<?php

namespace App\Command\FleetManagement;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\FleetManagement\Vehicle;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'fleet:create-vehicle',
    description: 'fleet vehicle creation',
)]
class FleetCreateVehicleCommand extends Command
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
            ->addArgument('plateNumber', InputArgument::REQUIRED, 'The plate number of the vehicle')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $plate_number = $input->getArgument('plateNumber');

        if ($plate_number) {
            try {
                $vehicle = new Vehicle();
                $vehicle->setPlateNumber($plate_number);
                $this->entityManager->persist($vehicle);
                $this->entityManager->flush();
                $io->success('Vehicle created [id: ' . $vehicle->getId() . ']');
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
