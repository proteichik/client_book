<?php

namespace Statistic\BasicBundle\Command;

use Symfony\Component\Console\Command\Command;
use Statistic\BasicBundle\Service\RecordService;
use ClientBundle\Logger\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveEmptyRecordCommand extends Command
{
    /**
     * @var RecordService
     */
    protected $service;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * RemoveEmptyRecordCommand constructor.
     * @param RecordService $service
     * @param LoggerInterface $logger
     */
    public function __construct(RecordService $service, LoggerInterface $logger)
    {
        $this->service = $service;
        $this->logger = $logger;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('statistic:remove:empty')
            ->setDescription('Remove empty record from statistic');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->logger->info('Start command [statistic:remove:empty]');

        $search_options = array(
            'criteria' => array(
                'countCalls' => 0,
                'countMeetings' => 0,
            ),
        );
        $records = $this->service->findBy($search_options);
        $this->logger->info(sprintf('Total records = %s', count($records)));

        foreach ($records as $record) {
            $this->logger->info(sprintf('Record by %s has been removed', $record->getDate()->format('Y-m-d H:i:s')));
            $this->service->remove($record, false);
        }

        $this->service->flush();
        $this->logger->info('Finish command [statistic:remove:empty]');
    }


}