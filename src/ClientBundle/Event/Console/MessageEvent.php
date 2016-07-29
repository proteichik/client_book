<?php

namespace ClientBundle\Event\Console;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class MessageEvent
 * @package ClientBundle\Event\Console
 */
class MessageEvent extends Event
{
    const INFO_MESSAGE = 'client.console_message_info';
    const ERROR_MESSAGE = 'client.console_message_error';

    /**
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $context;

    /**
     * @param string $message
     * @param array $context
     */
    public function __construct($message = '', array $context = array())
    {
        $this->message = $message;
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param array $context
     */
    public function setContext(array $context = array())
    {
        $this->context = $context;
    }
}