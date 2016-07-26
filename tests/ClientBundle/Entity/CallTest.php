<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Call;
use ClientBundle\Entity\Customer;
use ClientBundle\Entity\User;

class CallTest extends \PHPUnit_Framework_TestCase
{
    private $call;

    public function setUp()
    {
        $this->call = new Call();
    }

    public function testEmptyObject()
    {
        $this->assertNull($this->call->getId());
        $this->assertNull($this->call->getCustomer());
        $this->assertNull($this->call->getDate());
        $this->assertSame(Call::DONE_TYPE, $this->call->getStatus());
        $this->assertNull($this->call->getInfo());
        $this->assertNull($this->call->getCreatedAt());
        $this->assertNull($this->call->getAlias());
        $this->assertNull($this->call->getUser());

        $this->assertTrue($this->call->isDoneEvent());
    }

    public function testFillObject()
    {
        $customer = $this->getMockBuilder('ClientBundle\Entity\Customer')->getMock();
        $customer->expects($this->once())
            ->method('getId')
            ->will($this->returnValue(2));

        $this->call->setCustomer($customer);
        $this->assertEquals($customer, $this->call->getCustomer());

        $date = new \DateTime();
        $this->call->setDate($date);
        $this->assertEquals($date, $this->call->getDate());

        $this->call->setStatus(Call::PLANNED_TYPE);
        $this->assertEquals(Call::PLANNED_TYPE, $this->call->getStatus());
        $this->assertFalse($this->call->isDoneEvent());


        $this->call->setInfo('test info');
        $this->assertEquals('test info', $this->call->getInfo());

        $this->call->setCreatedAt();
        $this->assertTrue($this->call->getCreatedAt() instanceof \DateTime);

        $this->call->setAlias();
        $this->assertEquals('2-'.$this->call->getDate()->getTimestamp(), $this->call->getAlias());

        $user = new User();
        $this->call->setUser($user);
        $this->assertEquals($user, $this->call->getUser());

    }

    public function testTypeErrorDate()
    {
        try{
            $this->call->setDate('test');
            $this->fail('Must be type error (date)!');
        } catch (\Exception $ex) {

        }
    }

    public function testTypeErrorCustomer()
    {
        try {
            $this->call->setCustomer('test');
            $this->fail('Must be type error (customer)');
        } catch(\Exception $ex) {


        }
    }

}
