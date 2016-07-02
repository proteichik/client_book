<?php

namespace Tests\ClientBundle\Form\DataTransformer;

use ClientBundle\Entity\Call;
use ClientBundle\Form\DataTransformer\EntityTransformer;

class EntityTransformerTest extends \PHPUnit_Framework_TestCase
{
    private $dataTransformer;

    public function setUp()
    {
        $manager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        $repository = 'ClientBundle:Call';

        $this->dataTransformer = new EntityTransformer($manager, $repository);
    }

    public function testSetRepositoryClass()
    {
        $fake_repository = new Call();
        $manager = $this->getMockBuilder('Doctrine\ORM\EntityManager')->disableOriginalConstructor()->getMock();
        try {
            $dataTransformer = new EntityTransformer($manager, $fake_repository);
            $this->fail('Must throw exception');
        } catch(\Exception $ex)
        {

        }
    }

    public function testTransform()
    {
        $entity = $this->getMockBuilder('ClientBundle\Entity\Call')->getMock();
        $entity->expects($this->once())->method('getId')->will($this->returnValue(123));

        $result = $this->dataTransformer->transform($entity);
        $this->assertEquals($result, 123);
    }

    public function testReverseTransform()
    {
        $repositoryMock = $this->getMockBuilder('Doctrine\ORM\EntityRepository')->disableOriginalConstructor()->getMock();

        $manager = $this->dataTransformer->getManager();
        $manager->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo($this->dataTransformer->getRepositoryClass()))
            ->will($this->returnValue($repositoryMock));

        $repositoryMock->expects($this->at(0))
            ->method('find')
            ->will($this->returnValue(null));

        $repositoryMock->expects($this->at(1))
            ->method('find')
            ->will($this->returnValue(new Call()));

        try{
            $this->dataTransformer->reverseTransform(123);
            $this->fail('Must throw Exception');
        } catch(\Exception $ex)
        {

        }

        $result = $this->dataTransformer->reverseTransform(123);
        $this->assertTrue($result instanceof Call);
    }

}