<?php

namespace Statistic\BasicBundle\Command;

use Symfony\Component\Console\Command\Command;
use Statistic\BasicBundle\Service\RecordService;
use ClientBundle\Logger\LoggerInterface;

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
    }


}