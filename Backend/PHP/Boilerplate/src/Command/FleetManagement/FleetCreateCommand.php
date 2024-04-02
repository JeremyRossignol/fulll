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
use App\Entity\FleetManagement\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;


#[AsCommand(
    name: 'fleet:create',
    description: 'fleet creation',
)]
class FleetCreateCommand extends Command
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
            ->addArgument('userId', InputArgument::REQUIRED, 'The id of the owner user')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $user_id = intval($input->getArgument('userId'));

        if ($user_id) {
            try {
                $user = $this->entityManager->getRepository(User::class)->find($user_id);
                if ($user) {
                    $fleet = new Fleet();
                    $fleet->setUser($user);
                    $this->entityManager->persist($fleet);
                    $this->entityManager->flush();
                    $io->success('Fleet created');
                } else {
                    $io->error('User not found');
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
