<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Command\FleetManagement\{
    FleetCreateCommand
};

#[AsCommand(
    name: 'fleet',
    description: 'fleetmanagement',
)]
class FleetCommand extends Command
{
    public static $action_list = ['create', 'create-vehicle', 'create-location', 'create-user', 'register-vehicle', 'localize-vehicle'];

    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('action', InputArgument::REQUIRED, 'action in : create, create-vehicle, create-location, create-user, register-vehicle, localize-vehicle')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $action = $input->getArgument('action');

        if ($action) {
            if (in_array($action, self::$action_list)) {
                $command = new FleetCreateCommand();
                $command->execute($input, $output);
            } else {
                $io->error('Action not recognized');
                return Command::FAILURE;
            }
        } else {
            $io->error('Action not found');
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
