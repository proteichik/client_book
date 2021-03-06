<?php

namespace ClientBundle\Command;

use ClientBundle\Command\Base\AbstractBaseCommand;
use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Service\ServiceInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteOlderEventsCommand extends AbstractBaseCommand
{
    protected function configure()
    {
        $this->setName('client:delete:older')
            ->setDescription('Deletion older events')
            ->addArgument('type', InputArgument::REQUIRED)
            ->addArgument('interval', InputArgument::OPTIONAL)
            ->addOption('test', InputOption::VALUE_OPTIONAL)
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dispatchInfoMsg(sprintf('Start command [client:delete:older] with type [%s]', $input->getArgument('type')));

        $interval = ($this->getContainer()->hasParameter('event_delete_interval')) ?
            $this->getContainer()->getParameter('event_delete_interval') : $input->getArgument('interval');

        if (!$interval) {
            $this->dispatchErrorMsg('Have not parameter interval or event_delete_interval!');
            return;
        }

        $factory = $this->getContainer()->get('client.factory.event_command_factory');

        try {
            $service = $factory->getService($input->getArgument('type'));
        } catch(\Exception $ex) {
            $this->dispatchErrorMsg($ex->getMessage());
            return;
        }

        $date = $this->getDate($interval);
        $this->dispatchInfoMsg(sprintf('Date: %s', $date->format('Y-m-d H:i:s')));

        $objects = $this->getObjects($service, $date);
        $this->dispatchInfoMsg(sprintf('Total objects: %s', count($objects)));

        foreach ($objects as $object) {
            $service->remove($object, false);
            $this->dispatchInfoMsg(sprintf('Remove: (id: %s, date: %s)', $object->getId(), $object->getDate()->format('Y-m-d H:i:s')));
        }

        if (!$input->getOption('test')) {
            $service->flush();
            $this->dispatchInfoMsg('FLUSH');
        }

        $this->dispatchInfoMsg(sprintf('Finish command [client:delete:older] with type [%s]', $input->getArgument('type')));
        $this->dispatchInfoMsg('***');
    }

    protected function getDate($interval)
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval($interval));
        $date->setTime(23, 59, 59);

        return $date;
    }

    protected function getObjects(ServiceInterface $service, $date)
    {

        $query = $service->getQueryBuilder('q');
        $query->where('q.status = :status')
            ->andWhere('q.date <= :date')
            ->setParameter('status', AbstractEvent::PLANNED_TYPE)
            ->setParameter('date', $date);

        return $query->getQuery()->getResult();

    }

}