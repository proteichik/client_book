<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Customer;
use ClientBundle\Entity\Embeddable\Address;
use ClientBundle\Entity\Embeddable\Contacts;
use ClientBundle\Entity\User;
use ClientBundle\Entity\Call;
use ClientBundle\Entity\Meeting;

use ClientBundle\Model\EntityInterface;
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

        $this->assertTrue($this->customer->getMeetings() instanceof ArrayCollection);
        $this->assertEquals(0, $this->customer->getMeetings()->count());
        $this->assertSame(0, $this->customer->getStatus());
        $this->assertFalse($this->customer->isRemoved());
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

        //Call
        $call1 = new Call();
        $call2 = new Call();
        $this->customer->addCall($call1);
        $this->customer->addCall($call2);
        $this->assertEquals(2, $this->customer->getCalls()->count());

        $this->customer->removeCall($call1);
        $this->assertEquals(1, $this->customer->getCalls()->count());

        $fake_call = new Call();
        $this->customer->removeCall($fake_call);
        $this->assertEquals(1, $this->customer->getCalls()->count());

        //Meeting
        $meeting = new Meeting();
        $this->customer->addMeeting($meeting);
        $this->assertEquals(1, $this->customer->getMeetings()->count());

        $this->customer->removeMeeting($meeting);
        $this->assertEquals(0, $this->customer->getMeetings()->count());

        $fake_meeting = new Meeting();
        $this->customer->addMeeting($meeting);
        $this->customer->removeMeeting($fake_meeting);
        $this->assertEquals(1, $this->customer->getMeetings()->count());

        $this->customer->setStatus(EntityInterface::REMOVED_TYPE);
        $this->assertSame(EntityInterface::REMOVED_TYPE, $this->customer->getStatus());
        $this->assertTrue($this->customer->isRemoved());
    }
}