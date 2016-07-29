<?php

namespace ClientBundle\Logger;

use ClientBundle\Logger\LoggerInterface as BaseInterface;
use Psr\Log\LoggerInterface;

class ConsoleLogger implements BaseInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function info($message, array $context = array())
    {
        $this->logger->info($message, $context);
    }

    public function error($message, array $context = array())
    {
        $this->logger->error($message, $context);
    }

    public function warning($message, array $context = array())
    {
        $this->logger->warning($message, $context);
    }


}