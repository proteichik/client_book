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

        $output->writeln($this->getInfoMsg('DELETE CUSTOMERS - START'));
        $customers = $customerService->findBy($searchOptions);
        $output->writeln($this->getInfoMsg(
            sprintf('Total customers: %s', count($customers))
        ));

        foreach ($customers as $customer)
        {
            $output->writeln($this->getInfoMsg(
                sprintf('Customers: %s', $customer->getCompany())
            ));
            $output->writeln($this->getInfoMsg('Search unprocessed events...'));

            if ($this->isUnprocessedEvents($callService, $customer)
                || $this->isUnprocessedEvents($meetingService, $customer))
            {
                $output->writeln($this->getWarningMsg('Found! Skip!'));
                continue;
            }

            $customerService->remove($customer, false);
            $output->writeln($this->getInfoMsg('Not found! Remove!'));
        }

        if (!$input->getOption('test')) {
            $customerService->flush();
            $output->writeln($this->getInfoMsg('FLUSH!'));
        }

        $output->writeln($this->getInfoMsg('DELETE CUSTOMERS - FINISH'));
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