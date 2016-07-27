<?php

namespace Tests\ClientBundle\EntityValidation;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\Customer;
use ClientBundle\Entity\Embeddable\Address;
use ClientBundle\Entity\Embeddable\Contacts;
use ClientBundle\Entity\User;

abstract class EventEVTestCase extends BaseEVTestCase
{
    public function testCallValidate()
    {
        $user = $this->getValidUser();
        $customer = $this->getValidCustomer();

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
    }

    public function testIsNoFutureDoneEventActivate()
    {
        $this->getValidObject();
        $this->assertTrue($this->isValid());

        $date = new \DateTime();

        //isNoFutureDoneEventActivate
        $date->modify('+ 1 day');;
        $this->object->setDate($date);
        $this->object->setStatus(AbstractEvent::DONE_TYPE);
        $this->assertFalse($this->isValid(array('activate')));
    }

    protected function getValidObject()
    {
        $user = $this->getValidUser();
        $customer = $this->getValidCustomer();

        $this->object->setDate(new \DateTime())->setCustomer($customer)->setUser($user);
    }

    protected function getValidCustomer()
    {
        $address = new Address();
        $address->setCity('test city');
        $address->setStreet('test street');
        $address->setUnp(123456789);

        $user = $this->getValidUser();

        $customer = new Customer();

        $customer
            ->setCompany('test company')
            ->setAddress($address)
            ->setUser($user);

        return $customer;

    }

    protected function getValidUser()
    {
        return new User();
    }

}