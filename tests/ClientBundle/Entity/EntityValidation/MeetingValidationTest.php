<?php

namespace Tests\ClientBundle\Entity\EntityValidation;

use ClientBundle\Entity\Meeting;

class MeetingValidationTest extends EventEVTestCase
{
    protected function getObject()
    {
        return new Meeting();
    }



}