<?php

namespace Mindbird\Contao\SisBundle\Command;

use Mindbird\Contao\SisBundle\Model\SisLeagueModel;
use Mindbird\Contao\SisBundle\Service\Sis;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SisUpdateAllCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('sis:update')
            ->setDescription('Update every registered league');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $this->getApplication()->find('sis:update-league');

        $leagues = SisLeagueModel::findAll();
        if ($leagues !== null) {
            while ($leagues->next()) {
                $arguments = [
                    'sisId' => $leagues->sisId
                ];

                $command->run(new ArrayInput($arguments), $output);
            }
        }
    }
}
