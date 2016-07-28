<?php

namespace ClientCommandBundle\Factory;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ClientCommandFactory
 * @package ClientCommandBundle\Factory
 */
class ClientCommandFactory
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $type
     * @return object
     * @throws \Exception
     */
    public function getService($type)
    {
        switch ($type)
        {
            case 'call':
                $service = $this->get('client.service.call');
                break;
            case 'meeting':
                $service = $this->get('client.service.meeting');
                break;
            case 'customer':
                $service = $this->get('client.service.customer');
                break;
            default:
                throw new \Exception(sprintf('Type %s not defined if factory', $type));
        }

        return $service;
    }

    /**
     * @param $name
     * @return object
     * @throws \Exception
     */
    protected function get($name)
    {
        if (!$this->container->has($name)) {
            throw new \Exception(sprintf('Service %s not defined in container', $name));
        }

        return $this->container->get($name);
    }

    /**
     * @param $name
     * @return bool
     */
    protected function hasParameter($name)
    {
        return $this->container->hasParameter($name);
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    protected function getParameter($name, $default)
    {
        return ($this->hasParameter($name)) ? $this->container->getParameter($name) : $default;
    }
}