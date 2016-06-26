<?php

namespace Tests\ClientBundle\Service;

use ClientBundle\Entity\Call;
use ClientBundle\Service\BaseService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class BaseServiceTest extends \PHPUnit_Framework_TestCase
{
    private $service;
    private $em;
    private $entityClass;
    private $mockRepository;

    public function setUp()
    {
        $this->em = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $this->entityClass = 'ClientBundle:Call';
        $this->service = new BaseService($this->em, $this->entityClass);
        $this->mockRepository = $this->getMockBuilder('Doctrine\ORM\EntityRepository')->disableOriginalConstructor()->getMock();;
    }

    public function testConstructWithInvalidArgument()
    {
        try {
            $fake_entity_class = new Call();
            $this->service->setEntityClass($fake_entity_class);
            $this->fail('Must throw exception');
        } catch(\Exception $ex)
        {

        }
    }

    public function testFind()
    {
        $id = 1;
        $call = new Call();

        $this->em->expects($this->once())
            ->method('getRepository')
            ->with($this->identicalTo($this->entityClass))
            ->will($this->returnValue($this->mockRepository))
        ;

        $this->mockRepository->expects($this->once())
            ->method('find')
            ->with($this->identicalTo($id))
            ->will($this->returnValue($call));

        $result = $this->service->find($id);
        $this->assertSame($result, $call);
    }

    public function testFindBy()
    {
        $fake_options = array('test1' => 'test1', 'test2' => 'test2');

        try {
            $result = $this->service->findBy($fake_options);
            $this->fail('Must throw Exception');
        } catch(\Exception $ex) {

        }

        $fake_options = array(
            'criteria' => 1
        );

        try {
            $result = $this->service->findBy($fake_options);
            $this->fail('Must throw Exception');
        } catch (\Exception $ex) {

        }

        $option = array(
            'criteria' => array('id' => 1),
        );
        $this->em->expects($this->any())
            ->method('getRepository')
            ->with($this->identicalTo($this->entityClass))
            ->will($this->returnValue($this->mockRepository))
        ;
        $this->mockRepository->expects($this->at(0))
            ->method('findBy')
            ->with($this->identicalTo(array('id' => 1)), $this->identicalTo(array()))
            ;
        $this->mockRepository->expects($this->at(1))
            ->method('findBy')
            ->with($this->identicalTo(array('id' => 1)), $this->identicalTo(array('name' => 'ASC')))
        ;

        $result = $this->service->findBy($option);

        $option['order'] = 111;
        try {
            $this->service->findBy($option);
            $this->fail('Must throw Exception');
        } catch(\Exception $ex) {

        }
        $option['order'] = array('name' => 'ASC');


        $result = $this->service->findBy($option);

    }
}