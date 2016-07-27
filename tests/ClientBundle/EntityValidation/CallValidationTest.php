<?php

namespace Tests\ClientBundle\EntityValidation;

use ClientBundle\Entity\Call;

class CallValidationTest extends EventEVTestCase
{
    protected function getObject()
    {
        return new Call();
    }

}