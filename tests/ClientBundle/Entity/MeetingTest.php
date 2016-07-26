<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Meeting;
use ClientBundle\Entity\Customer;
use ClientBundle\Entity\User;

class MeetingTest extends \PHPUnit_Framework_TestCase
{
    private $meeting;

    public function setUp()
    {
        $this->meeting = new Meeting();
    }

    public function testEmptyObject()
    {
        $this->assertNull($this->meeting->getId());
        $this->assertNull($this->meeting->getCustomer());
        $this->assertNull($this->meeting->getDate());
        $this->assertSame(Meeting::DONE_TYPE,$this->meeting->getStatus());
        $this->assertNull($this->meeting->getInfo());
        $this->assertNull($this->meeting->getCreatedAt());
        $this->assertNull($this->meeting->getAlias());
        $this->assertNull($this->meeting->getUser());
    }

    public function testCustomer()
    {
        $fake_customer = '123456';
        try {
            $this->meeting->setCustomer($fake_customer);
            $this->fail('Must throw exception');
        } catch(\Exception $ex)
        {
            $customer = new Customer();
            $this->meeting->setCustomer($customer);
            $this->assertSame($customer, $this->meeting->getCustomer());

            $secondCustomer = new Customer();
            $this->assertNotSame($secondCustomer, $this->meeting->getCustomer());
        }
    }

    public function testDate()
    {
        $fake_date = 'fake date';
        try {
            $this->meeting->setDate($fake_date);
            $this->fail('Must throw exception');
        } catch(\Exception $ex)
        {
            $date = new \DateTime();
            $secondDate = new \DateTime();

            $this->meeting->setDate($date);
            $this->assertSame($date, $this->meeting->getDate());
            $this->assertNotSame($secondDate, $this->meeting->getDate());
        }
    }

    public function testStatus()
    {
        $this->meeting->setStatus(AbstractEvent::DONE_TYPE);
        $this->assertEquals(AbstractEvent::DONE_TYPE, $this->meeting->getStatus());
    }

    public function testInfo()
    {
        $this->meeting->setInfo('test info');
        $this->assertEquals('test info', $this->meeting->getInfo());
    }

    public function testCreatedAt()
    {
        $this->meeting->setCreatedAt();
        $this->assertTrue($this->meeting->getCreatedAt() instanceof \DateTime);
    }

    public function testAlias()
    {
        $customer = $this->getMockBuilder('ClientBundle\Entity\Customer')->getMock();
        $customer->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(2));

        $this->meeting->setCustomer($customer);
        $this->meeting->setDate(new \DateTime());

        $this->meeting->setAlias();
        $this->assertEquals('2-'.$this->meeting->getDate()->getTimestamp(), $this->meeting->getAlias());

    }

    public function testUser()
    {
        $user = new User();
        $this->meeting->setUser($user);
        $this->assertEquals($user, $this->meeting->getUser());
    }
}