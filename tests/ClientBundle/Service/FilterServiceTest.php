<?php

namespace Tests\ClientBundle\Service;

use ClientBundle\Service\FilterService;

class FilterServiceTest extends \PHPUnit_Framework_TestCase
{
    private $entityName;
    private $em;
    private $filterBuilder;
    private $service;

    public function setUp()
    {
        $this->em = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->filterBuilder = $this->getMockBuilder('Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater')
            ->disableOriginalConstructor()->getMock();
        $this->entityName = 'ClientBundle:Call';

        $this->service = new FilterService($this->em, $this->entityName, $this->filterBuilder);
    }

    public function testGetFilteredList()
    {
        $fakeRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()->getMock();

        $repository = $this->getMockBuilder('ClientBundle\Repository\EventRepository')
            ->disableOriginalConstructor()->getMock();

        $this->em->expects($this-at(0))
            ->method('getRepository')
            ->with($this->identicalTo($this->entityName))
            ->will($this->returnValue($fakeRepository));

        $this->em->expects($this-at(1))
            ->method('getRepository')
            ->with($this->identicalTo($this->entityName))
            ->will($this->returnValue($fakeRepository));


    }

}