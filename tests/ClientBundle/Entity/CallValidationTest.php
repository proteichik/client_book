<?php

namespace Tests\ClientBundle\Entity;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Call;
use ClientBundle\Entity\Customer;
use ClientBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CallValidationTest extends KernelTestCase
{
    protected $object;
    protected $validator;

    public function setUp()
    {
        self::bootKernel();

        $this->validator = self::$kernel->getContainer()->get('validator');
        $this->object = new Call();
    }

    public function testCallValidate()
    {
        $user = new User();
        $customer = new Customer();
        $customer->setUser($user);
        $customer->setCompany('test company');

        //not Valid :( empty User, Customer, Date
        $this->assertFalse($this->isValid());

        //not Valid :( empty User, Customer
        $this->object->setDate(new \DateTime());
        $this->assertFalse($this->isValid());

        //not Valid :( empty User
        $this->object->setCustomer($customer);
        $this->assertFalse($this->isValid());

        //Valid! :)
        $this->object->setUser($user);
        $this->assertTrue($this->isValid());

    }

    public function testConstraintNearEvent()
    {
        $this->getValidObject();
        $this->assertTrue($this->isValid());

        $date = new \DateTime();

        $date->modify('- 1 year');
        $this->object->setDate($date);
        $this->assertFalse($this->isValid());
    }

    public function testIsValidStatus()
    {
        $this->getValidObject();
        $this->assertTrue($this->isValid());

        $date = new \DateTime();
        $this->object->setDate($date);
        $this->object->setStatus(AbstractEvent::PLANNED_TYPE);
        $this->assertFalse($this->isValid());
    }

    public function testIsNoFutureDoneEventCreation()
    {
        $this->getValidObject();
        $this->assertTrue($this->isValid());

        $date = new \DateTime();

        //isNoFutureDoneEventCreation
        $date->modify('+ 5 minutes');;
        $this->object->setDate($date);
        $this->object->setStatus(AbstractEvent::DONE_TYPE);
        $this->assertFalse($this->isValid(array('creation')));
        $this->assertTrue($this->isValid(array('activate')));

//        $errors = $this->getErrors();
//        var_dump($errors);
//        var_dump($this->object);
    }

    protected function getErrors($groups = array())
    {
        return $this->validator->validate($this->object, null, $groups);
    }

    protected function isValid($groups = array())
    {
        return (count($this->getErrors($groups)) === 0);
    }

    private function getValidObject()
    {
        $user = new User();
        $customer = new Customer();
        $customer->setUser($user);
        $customer->setCompany('test company');

        $this->object->setDate(new \DateTime())->setCustomer($customer)->setUser($user);
    }
}