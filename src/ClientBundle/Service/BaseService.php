<?php

namespace ClientBundle\Service;

use ClientBundle\Repository\InternalRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class BaseService
 * @package ClientBundle\Service
 */
class BaseService implements ServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var string
     */
    protected $repositoryName;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param $repositoryName
     */
    public function __construct(EntityManagerInterface $em, $repositoryName)
    {
        $this->em = $em;
        $this->setRepositoryName($repositoryName);
    }

    /**
     * @param EntityManagerInterface $em
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $em)
    {
        $this->em = $em;

        return $this;
    }

    /**
     * @param $repositoryName
     * @return $this
     */
    public function setRepositoryName($repositoryName)
    {
        if (!is_string($repositoryName)) {
            throw new \InvalidArgumentException('Entity Class must be a string!');
        }

        $this->repositoryName = $repositoryName;

        return $this;
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->getRepository()->find($id);
    }

    /**
     * @param array $options
     * @return array
     */
    public function findBy($options = array())
    {

        if (!isset($options['criteria'])) {
            throw new \InvalidArgumentException('Search criteria not defined!');
        }

        if (!is_array($options['criteria'])) {
            throw new \InvalidArgumentException('Search criteria must be array!');
        }

        $criteria = $options['criteria'];
        $order = (isset($options['order'])) ? $options['order'] : array();
        $limit = (isset($options['limit'])) ? $options['limit'] : null;

        if (!is_array($order)) {
            throw new \InvalidArgumentException('Search order must be array!');
        }

        if (null !== $limit && !is_int($limit)) {
            throw new \InvalidArgumentException('Limit must be integer');
        }

        return $this->getRepository()->findBy($criteria, $order, $limit);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->getQueryAllBuilder();
    }

    /**
     * @param $object
     * @return void
     */
    public function save($object)
    {
        $this->persist($object);
        $this->flush();
    }

    /**
     * @param $object
     * @return void
     */
    public function remove($object)
    {
        $this->em->remove($object);
        $this->flush();
    }

    /**
     * @param $object
     */
    public function persist($object)
    {
        $this->em->persist($object);
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->em->flush();
    }

    protected function getRepository()
    {
        $repository = $this->em->getRepository($this->repositoryName);
        
        if (!$repository instanceof InternalRepositoryInterface) {
            throw new \InvalidArgumentException('Repository must implements InternalRepositoryInterface ');
        }

        return $repository;
    }
}