<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use Symfony\Component\Console\Input\ArrayInput;

#[AsCommand(
    name: 'fleet',
    description: 'fleet management',
)]
class FleetCommand extends Command
{
    public static $action_list = ['create', 'create-vehicle', 'create-location', 'create-user', 'register-vehicle', 'localize-vehicle', 'park-vehicule'];

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'action in : create, create-vehicle, create-location, create-user, register-vehicle, localize-vehicle, park-vehicule')
            ->addArgument(
                'param1',
                InputArgument::REQUIRED,
                'On fleet creation : the id of the owner user\n'
                    . 'On vehicle creation : the plate number\n'
                    . 'On location creation : the latitude\n'
                    . 'On user creation : the name\n'
                    . 'On vehicle registration : the id of the fleet\n'
                    . 'On vehicle localization : the id of the fleet'
                    . 'On vehicle park : the id of the fleet'
            )
            ->addArgument(
                'param2',
                InputArgument::OPTIONAL,
                'On location creation : the longitude\n'
                    . 'On vehicle registration : the plate number of the vehicle\n'
                    . 'On vehicle localization : the plate number of the vehicle'
                    . 'On vehicle park : the plate number of the vehicle'
            )
            ->addArgument(
                'param3',
                InputArgument::OPTIONAL,
                'On vehicle park : the id of the location\n'
            )
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $action = $input->getArgument('action');

        if ($action) {
            switch ($action) {
                case 'create':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:create',
                        'userId' => $input->getArgument('param1'),
                    ]);
                    break;
                case 'create-vehicle':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:create-vehicle',
                        'plateNumber' => $input->getArgument('param1'),
                    ]);
                    break;
                case 'create-location':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:create-location',
                        'latitude' => $input->getArgument('param1'),
                        'longitude' => $input->getArgument('param2'),
                    ]);
                    break;
                case 'create-user':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:create-user',
                        'name' => $input->getArgument('param1'),
                    ]);
                    break;
                case 'register-vehicle':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:register-vehicle',
                        'fleetId' => $input->getArgument('param1'),
                        'vehiclePlateNumber' => $input->getArgument('param2'),
                    ]);
                    break;
                case 'localize-vehicle':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:localize-vehicle',
                        'fleetId' => $input->getArgument('param1'),
                        'vehiclePlateNumber' => $input->getArgument('param2'),
                    ]);
                    break;
                case 'park-vehicle':
                    $newInput = new ArrayInput([
                        'command' => 'fleet:park-vehicle',
                        'fleetId' => $input->getArgument('param1'),
                        'vehiclePlateNumber' => $input->getArgument('param2'),
                        'locationId' => $input->getArgument('param3'),
                    ]);
                    break;
                default:
                    $io->error('Action not recognized');
                    return Command::FAILURE;
            }

            $returnCode = $this->getApplication()->doRun($newInput, $output);
        } else {
            $io->error('Action not found');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
