<?php

namespace ClientBundle\Command;

use ClientBundle\Command\Base\AbstractBaseCommand;
use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCustomersCommand extends AbstractBaseCommand
{
    protected function configure()
    {
        $this
            ->setName('client:delete:customers')
            ->setDescription('Deletion customers')
            ->addOption('test', null, InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->dispatchInfoMsg('Start command [client:delete:customers]');

        /* @var ServiceInterface */
        $customerService = $this->getContainer()->get('client.service.customer');

        /* @var ServiceInterface */
        $callService = $this->getContainer()->get('client.service.call');

        /* @var ServiceInterface */
        $meetingService = $this->getContainer()->get('client.service.meeting');

        $searchOptions = array(
            'criteria' => array(
                'status' => EntityInterface::REMOVED_TYPE
            ),
        );

        $customers = $customerService->findBy($searchOptions);
        $this->dispatchInfoMsg(sprintf('Total customers: %s', count($customers)));

        foreach ($customers as $customer)
        {
            $this->dispatchInfoMsg(sprintf('Customers: %s', $customer->getCompany()));
            $this->dispatchInfoMsg('Search unprocessed events...');

            if ($this->isUnprocessedEvents($callService, $customer)
                || $this->isUnprocessedEvents($meetingService, $customer))
            {
                $this->dispatchWarningMsg('Found! Skip!');
                continue;
            }

            $customerService->remove($customer, false);
            $this->dispatchInfoMsg('Not found! Remove!');
        }

        if (!$input->getOption('test')) {
            $customerService->flush();
            $this->dispatchInfoMsg('FLUSH!');
        }
        
        $this->dispatchInfoMsg('Finish command [client:delete:customers]');
        $this->dispatchInfoMsg('***');
    }


    protected function isUnprocessedEvents(ServiceInterface $service, $customer)
    {
        $searchOptions = array(
            'criteria' => array(
                'processed' => false,
                'customer' => $customer,
            ),
        );

        $events = $service->findBy($searchOptions);

        return (count($events) > 0);
    }


}