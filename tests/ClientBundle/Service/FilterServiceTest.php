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

        $this->em->expects($this->at(0))
            ->method('getRepository')
            ->with($this->identicalTo($this->entityName))
            ->will($this->returnValue($fakeRepository));

        $this->em->expects($this->at(1))
            ->method('getRepository')
            ->with($this->identicalTo($this->entityName))
            ->will($this->returnValue($repository));
        
        $queryBuilder = $this->getMockBuilder('Doctrine\ORM\QueryBuilder')->disableOriginalConstructor()->getMock();
        $query = $this->getMockBuilder('Doctrine\ORM\Query')->disableOriginalConstructor()->getMock();
        
        $repository->expects($this->once())
            ->method('getFilteredBuilder')
            ->will($this->returnValue($queryBuilder));

        $form = $this->getMockBuilder('ClientBundle\Filter\FormFilter\EventFilter')
            ->disableOriginalConstructor()
            ->getMock();

        $this->filterBuilder->expects($this->once())
            ->method('addFilterConditions')
            ->with($this->identicalTo($form), $this->identicalTo($queryBuilder));

        $queryBuilder->expects($this->once())
            ->method('getQuery')
            ->will($this->returnValue($query));

        $query->expects($this->once())
            ->method('getResult');

        try {
            $this->service->getFilteredList($form);
            $this->fail('Must throw Exception');
        } catch(\Exception $ex)
        {
            $this->service->getFilteredList($form);
        }



    }

}