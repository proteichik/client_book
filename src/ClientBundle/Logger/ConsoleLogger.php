<?php

namespace ClientBundle\Logger;


use Psr\Log\LoggerInterface;

class ConsoleLogger
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

}