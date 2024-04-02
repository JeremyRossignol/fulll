<?php

namespace App\Command\FleetManagement;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Entity\FleetManagement\Location;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'fleet:create-location',
    description: 'fleet location creation',
)]
class FleetCreateLocationCommand extends Command
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
            ->addArgument('latitude', InputArgument::REQUIRED, 'The latitude of the location')
            ->addArgument('longitude', InputArgument::REQUIRED, 'The longitude of the longitude')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $latitude = $input->getArgument('latitude');
        $longitude = $input->getArgument('longitude');

        if ($latitude && $longitude) {
            try {
                $location = new Location();
                $location->setLatitude($latitude);
                $location->setLongitude($longitude);
                $this->entityManager->persist($location);
                $this->entityManager->flush();
                $io->success('Location created [id: ' . $location->getId() . ']');
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
