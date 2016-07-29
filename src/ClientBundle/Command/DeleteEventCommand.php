<?php

namespace ClientBundle\Command;

use ClientBundle\Model\EntityInterface;
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
        $factory = $this->getContainer()->get('client.factory.event_command_factory');
        $logger = $this->getContainer()->get('logger');
        $type = $input->getArgument('type');

        try {
            $service = $factory->getService($type);
        } catch (\Exception $ex)
        {
            $logger->error($ex->getMessage());
        }

        $searchParams = array(
            'criteria' => array(
                'status' => EntityInterface::REMOVED_TYPE,
                'processed' => false,
            ),
        );
        
        $objects = $service->findBy($searchParams);
        
        $logger->warning(sprintf('Items for remove: %s', count($objects)));
        
        foreach ($objects as $object) {
            $service->remove($object, false);
        }

        if (!$input->getOption('test')) {
            $service->flush();
        }

        $output->writeln('Items are removed');
        $logger->info('End');

    }


}