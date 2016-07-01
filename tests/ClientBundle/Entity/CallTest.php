<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\Call;
use ClientBundle\Entity\Customer;

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
        $this->assertNull($this->call->getStatus());
        $this->assertNull($this->call->getInfo());
        $this->assertNull($this->call->getCreatedAt());
    }

    public function testFillObject()
    {
        $customer = new Customer();

        $this->call->setCustomer($customer);
        $this->assertEquals($customer, $this->call->getCustomer());

        $date = new \DateTime();
        $this->call->setDate($date);
        $this->assertEquals($date, $this->call->getDate());

        $this->call->setStatus(Call::DONE_TYPE);
        $this->assertEquals(Call::DONE_TYPE, $this->call->getStatus());

        $this->call->setInfo('test info');
        $this->assertEquals('test info', $this->call->getInfo());

        $this->call->setCreatedAt();
        $this->assertTrue($this->call->getCreatedAt() instanceof \DateTime);

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
