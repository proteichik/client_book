<?php

namespace ClientBundle\Command\Base;

use ClientBundle\Event\Console\MessageEvent;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractBaseCommand extends ContainerAwareCommand
{
    protected function getInfoMsg($message)
    {
        $this->dispatch(MessageEvent::INFO_MESSAGE, $message);
        return '<info>[INFO]: ' . $message . '</info>';
    }

    protected function getErrorMsg($message)
    {
        $this->dispatch(MessageEvent::ERROR_MESSAGE, $message);
        return '<error>[ERROR]: ' . $message . '</error>';
    }

    protected function getWarningMsg($message)
    {
        $this->dispatch(MessageEvent::WARNING_MESSAGE, $message);
        return '<comment>[INFO]: ' . $message . '</comment>';
    }

    protected function dispatch($eventName, $message)
    {
        $dispatcher = $this->getDispatcher();
        $event = new MessageEvent($message);

        $dispatcher->dispatch($eventName, $event);
    }

    protected function getDispatcher()
    {
        return $this->getContainer()->get('event_dispatcher');
    }
}