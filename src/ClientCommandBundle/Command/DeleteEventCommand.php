<?php

namespace ClientCommandBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteEventCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('client:delete:event')
            ->setDescription('Delete events')
            ->addArgument('type', InputArgument::REQUIRED, 'Event type')
            ->addOption('test', null, InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }


}