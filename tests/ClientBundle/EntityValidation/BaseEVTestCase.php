<?php

namespace Tests\ClientBundle\EntityValidation;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BaseEVTestCase extends KernelTestCase
{
    protected $object;
    protected $validator;

    abstract protected function getObject();

    public function setUp()
    {
        self::bootKernel();

        $this->validator = self::$kernel->getContainer()->get('validator');
        $this->object = $this->getObject();
    }

    protected function getErrors($groups = array())
    {
        return $this->validator->validate($this->object, null, $groups);
    }

    protected function isValid($groups = array())
    {
        return (count($this->getErrors($groups)) === 0);
    }}