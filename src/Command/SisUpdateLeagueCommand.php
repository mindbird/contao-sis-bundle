<?php

namespace Mindbird\Contao\SisBundle\Command;

use Mindbird\Contao\SisBundle\Service\Sis;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SisUpdateLeagueCommand extends Command
{
    protected $sis;

    public function __construct(Sis $sis)
    {
        $this->sis = $sis;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('sis:update-league')
            ->addArgument('sisId', InputArgument::REQUIRED, 'SIS id of league')
            ->setDescription('Update standings and game data of league')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->sis->create($input->getArgument('sisId'));
        $output->writeln(['Update league #' . $input->getArgument('sisId')]);
    }
}
