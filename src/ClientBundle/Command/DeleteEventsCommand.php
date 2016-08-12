<?php

namespace ClientBundle\Command;

use ClientBundle\Command\Base\AbstractBaseCommand;
use ClientBundle\Model\EntityInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use ClientBundle\Traits\TraitMessageCommand;

class DeleteEventsCommand extends AbstractBaseCommand
{
    protected function configure()
    {
        $this
            ->setName('client:delete:events')
            ->setDescription('Delete events')
            ->addArgument('type', InputArgument::REQUIRED, 'Event type')
            ->addOption('test', null, InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $factory = $this->getContainer()->get('client.factory.event_command_factory');
        $type = $input->getArgument('type');
        $logger = $this->getContainer()->get('logger');
        $this->dispatchInfoMsg(sprintf('Start command [client:delete:events] with type [%s]', $type));

        try {
            $service = $factory->getService($type);
        } catch (\Exception $ex)
        {
            $this->dispatchErrorMsg($ex->getMessage());
            return;
        }

        $searchParams = array(
            'criteria' => array(
                'status' => EntityInterface::REMOVED_TYPE,
                'processed' => false,
            ),
        );

        $objects = $service->findBy($searchParams);
        $this->dispatchInfoMsg(sprintf('Total objects: %s', count($objects)));

        
        foreach ($objects as $object) {
            $service->remove($object, false);
            $this->dispatchInfoMsg(sprintf('Object (id: %s, date: %s) has been removed', $object->getId(), $object->getDate()->format('Y-m-d H:i:s')));

        }

        if (!$input->getOption('test')) {
            $service->flush();
            $this->dispatchInfoMsg('FLUSH!');
        }

        $this->dispatchInfoMsg(sprintf('Finish command [client:delete:events] with type [%s]', $type));
        $this->dispatchInfoMsg('***');
    }
}