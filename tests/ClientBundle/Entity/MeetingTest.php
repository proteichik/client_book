<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Meeting;
use ClientBundle\Entity\Customer;

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
        $this->assertNull($this->meeting->getStatus());
        $this->assertNull($this->meeting->getInfo());
        $this->assertNull($this->meeting->getCreatedAt());
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
}