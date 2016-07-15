<?php

namespace Tests\ClientBundle\Entity\Embeddable;

use ClientBundle\Entity\Embeddable\Address;

class AddressTest extends \PHPUnit_Framework_TestCase
{
    private $address;

    public function setUp()
    {
        $this->address = new Address();
    }

    public function testEmpty()
    {
        $this->assertNull($this->address->getCity());
        $this->assertNull($this->address->getUnp());
        $this->assertNull($this->address->getStreet());
    }

    public function testCity()
    {
        $this->address->setCity('test');
        $this->assertEquals('test', $this->address->getCity());
    }

    public function testStreet()
    {
        $this->address->setStreet('test street');
        $this->assertEquals('test street', $this->address->getStreet());
    }

    public function testUnp()
    {
        $this->address->setUnp(123456789);
        $this->assertEquals(123456789, $this->address->getUnp());
    }
}