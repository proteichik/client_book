<?php

namespace Tests\ClientBundle\Factory;

use ClientBundle\Factory\EventCommandFactory;
use ClientBundle\Service\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventCommandFactoryTest extends KernelTestCase
{
    private $factory;

    public function setUp()
    {
        self::bootKernel();;

        $container = self::$kernel->getContainer();
        $this->factory = new EventCommandFactory($container);
    }

    public function testGetService()
    {
        $fake_type = 'fake type';

        try {
            $this->factory->getService($fake_type);
            $this->fail('Must throw Exception');
        } catch(\Exception $ex) {

        }

        $callService = $this->factory->getService('call');

        $this->assertTrue($callService instanceof ServiceInterface);
    }
}