<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Customer;
use ClientBundle\Entity\Embeddable\Address;
use ClientBundle\Entity\Embeddable\Contacts;
use ClientBundle\Entity\User;
use ClientBundle\Entity\Call;
use ClientBundle\Entity\Meeting;

use Doctrine\Common\Collections\ArrayCollection;

class CustomerTest extends \PHPUnit_Framework_TestCase
{
    private $customer;

    public function setUp()
    {
        $this->customer = new Customer();
    }

    public function testEmptyObject()
    {
        $this->assertNull($this->customer->getId());
        $this->assertNull($this->customer->getCompany());
        $this->assertNull($this->customer->getAddress());
        $this->assertNull($this->customer->getContacts());
        $this->assertNull($this->customer->getInfo());
        $this->assertNull($this->customer->getUser());

        $this->assertTrue($this->customer->getCalls() instanceof ArrayCollection);
        $this->assertEquals(0, $this->customer->getCalls()->count());
    }

    public function testObjectWithData()
    {
        $this->customer->setCompany('test company');
        $this->assertEquals('test company', $this->customer->getCompany());
    }
}