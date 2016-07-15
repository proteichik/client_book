<?php

namespace Tests\ClientBundle\Entity\Embeddable;

use ClientBundle\Entity\Embeddable\Contacts;

class ContactsTest extends \PHPUnit_Framework_TestCase
{
    private $contacts;

    public function setUp()
    {
        $this->contacts = new Contacts();
    }

    public function testEmpty()
    {
        $this->assertNull($this->contacts->getWork());
        $this->assertNull($this->contacts->getMobile());
        $this->assertNull($this->contacts->getFax());
        $this->assertNull($this->contacts->getEmail());
    }

    public function testWork()
    {
        $this->contacts->setWork('222-22-22');
        $this->assertEquals('222-22-22', $this->contacts->getWork());
    }

    public function testMobile()
    {
        $this->contacts->setMobile('222-22-22');
        $this->assertEquals('222-22-22', $this->contacts->getMobile());
    }

    public function testFax()
    {
        $this->contacts->setFax('222-22-22');
        $this->assertEquals('222-22-22', $this->contacts->getFax());
    }

    public function testEmail()
    {
        $this->contacts->setEmail('test@test.by');
        $this->assertEquals('test@test.by', $this->contacts->getEmail());
    }

}