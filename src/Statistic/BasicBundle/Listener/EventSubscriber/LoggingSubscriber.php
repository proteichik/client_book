<?php

namespace Statistic\BasicBundle\Listener\EventSubscriber;

use Statistic\BasicBundle\Event\PostProcessEvent;
use Statistic\BasicBundle\Event\PreProcessEvent;
use Statistic\BasicBundle\Event\ProcessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;

class LoggingSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * LoggingSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    public static function getSubscribedEvents()
    {
        return array(
            PreProcessEvent::NAME => 'onPreProcess',
            ProcessEvent::NAME => 'onProcess',
            PostProcessEvent::NAME => 'onPostProcess',
        );
    }

    public function onPreProcess(PreProcessEvent $event)
    {
        $this->logger->warning(sprintf('Items to process: %s', count($event->getItems())));
    }

    public function onProcess(ProcessEvent $event)
    {
        $item = $event->getItem();
//        $record = $event->getRecord();

        $this->logger->warning(sprintf('Event: %s [id] - %s[date] - %s[user]',
            $item->getId(),
            $item->getDate()->format('Y-m-d H:i:s'),
            $item->getUser()->getUsername()
        ));
    }

    public function onPostProcess(PostProcessEvent $event)
    {

    }
}