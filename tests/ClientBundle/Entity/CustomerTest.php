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

        //Invalid address type
        try {
            $this->customer->setAddress('invalid type');
            $this->fail('Must throw exception');
        } catch(\Exception $ex)
        {

        }

        //Valid address type
        $address = new Address();
        $this->customer->setAddress($address);
        $this->assertSame($address, $this->customer->getAddress());

        //Invalid contact type
        try {
            $this->customer->setContacts('invalid contacts');
            $this->fail('Must throw exception');
        } catch(\Exception $ex) {

        }

        //Valid contact type
        $contact = new Contacts();
        $this->customer->setContacts($contact);
        $this->assertSame($contact, $this->customer->getContacts());

        $this->customer->setInfo('test info');
        $this->assertEquals('test info', $this->customer->getInfo());

        $call1 = new Call();
        $call2 = new Call();
        $this->customer->addCall($call1);
        $this->customer->addCall($call2);
        $this->assertEquals(2, $this->customer->getCalls()->count());

        $this->customer->removeCall($call1);
        $this->assertEquals(1, $this->customer->getCalls()->count());

    }
}