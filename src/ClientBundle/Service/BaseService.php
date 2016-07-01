<?php

namespace ClientBundle\Service;

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
    protected $entityClass;

    /**
     * Constructor
     *
     * @param EntityManagerInterface $em
     * @param $entityClass
     */
    public function __construct(EntityManagerInterface $em, $entityClass)
    {
        $this->em = $em;
        $this->setEntityClass($entityClass);
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
     * @param $entityClass
     * @return $this
     */
    public function setEntityClass($entityClass)
    {
        if (!is_string($entityClass)) {
            throw new \InvalidArgumentException('Entity Class must be a string!');
        }

        $this->entityClass = $entityClass;

        return $this;
    }

    /**
     * @param $id
     * @return object
     */
    public function find($id)
    {
        return $this->em->getRepository($this->entityClass)->find($id);
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

        if (!is_array($order)) {
            throw new \InvalidArgumentException('Search order must be array!');
        }

        return $this->em->getRepository($this->entityClass)->findBy($criteria, $order);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->em->getRepository($this->entityClass)->findAll();
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
}