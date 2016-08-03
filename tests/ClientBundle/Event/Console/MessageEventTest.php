<?php

namespace Tests\ClientBundle\Event\Console;

use ClientBundle\Event\Console\MessageEvent;

class MessageEventTest extends \PHPUnit_Framework_TestCase
{
    private $event;

    public function setUp()
    {
        $this->event = new MessageEvent();
    }

    public function testEmptyObject()
    {
        $this->assertEquals('', $this->event->getMessage());
        $this->assertEquals(array(), $this->event->getContext());
    }

    public function testMessage()
    {
        $this->event->setMessage('test');
        $this->assertEquals('test', $this->event->getMessage());
    }

    public function testContext()
    {
        $this->event->setContext(array('test context'));
        $this->assertEquals(array('test context'), $this->event->getContext());
    }
}