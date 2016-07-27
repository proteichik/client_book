<?php

namespace Tests\ClientBundle\EntityValidation;

use ClientBundle\Entity\Customer;
use ClientBundle\Entity\Embeddable\Address;
use ClientBundle\Entity\Embeddable\Contacts;
use ClientBundle\Entity\User;

class CustomerValidationTest extends BaseEVTestCase
{
    protected function getObject()
    {
        return new Customer();
    }

    public function testPropertiesValidate()
    {
        //Entity is empty
        //Company, Address, User is blank
        $this->assertFalse($this->isValid());

        //Address, User is blank
        $this->object->setCompany('test company');
        $this->assertFalse($this->isValid());

        //User is blank
        $address = new Address();
        $address->setCity('test city');
        $address->setStreet('test street');
        $address->setUnp(123456789);
        $this->object->setAddress($address);
        $this->assertFalse($this->isValid());

        //VALID!
        $user = new User();
        $this->object->setUser($user);
        $this->assertTrue($this->isValid());
    }

}