<?php

namespace Statistic\BasicBundle\Factory;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractCommandFactory
{
    use ContainerAwareTrait;

    abstract public function getReader($type);
    abstract public function getProcessor();
    
    protected function get($alias)
    {
        return $this->container->get($alias);
    }
}