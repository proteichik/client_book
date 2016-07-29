<?php

namespace ClientBundle\EventSubscriber\Console;

use ClientBundle\Event\Console\MessageEvent;
use ClientBundle\Logger\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageSubscriber implements EventSubscriberInterface
{
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return array(
            MessageEvent::INFO_MESSAGE => 'processInfo',
            MessageEvent::ERROR_MESSAGE => 'processError',
            MessageEvent::WARNING_MESSAGE => 'processWarning',
        );
    }

    public function processInfo(MessageEvent $event)
    {
        $this->logger->info($event->getMessage(), $event->getContext());
    }

    public function processError(MessageEvent $event)
    {
        $this->logger->error($event->getMessage(), $event->getContext());
    }

    public function processWarning(MessageEvent $event)
    {
        $this->logger->warning($event->getMessage(), $event->getContext());
    }
}