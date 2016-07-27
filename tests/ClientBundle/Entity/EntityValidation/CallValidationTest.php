<?php

namespace Tests\ClientBundle\Entity\EntityValidation;

use ClientBundle\Entity\Call;

class CallValidationTest extends EventEVTestCase
{
    protected function getObject()
    {
        return new Call();
    }

}