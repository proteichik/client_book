<?php

namespace Tests\ClientBundle\Filter\SQLFilter;

use ClientBundle\Filter\SQLFilter\ByIdOwnerFilter;

class ByIdOwnerFilterTest extends \PHPUnit_Framework_TestCase
{
    private $filter;

    public function setUp()
    {
        $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();

        $this->filter = new ByIdOwnerFilter($em);
    }

    public function testExecute()
    {

    }
}