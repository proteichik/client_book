<?php

namespace Statistic\BasicBundle\Service;

use ClientBundle\Service\ServiceInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RecordService
{
    /**
     * @var ObjectManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_entityName;

    /**
     * RecordService constructor.
     * @param ObjectManager $_em
     * @param string $_entityName
     */
    public function __construct(ObjectManager $_em, $_entityName)
    {
        $this->_em = $_em;
        $this->setEntityName($_entityName);
    }

    /**
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * @param ObjectManager $em
     * @return $this
     */
    public function setEntityManager(ObjectManager $em)
    {
        $this->_em = $em;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->_entityName;
    }

    /**
     * @param $entityName
     * @return $this
     */
    public function setEntityName($entityName)
    {
        if (!is_string($entityName)) {
            throw new \InvalidArgumentException('Entity name must be a string');
        }

        $this->_entityName = $entityName;

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
     * @return array
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
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
     * @param object $object
     * @return object
     */
    public function save($object)
    {
        $this->persist($object);
        $this->flush();

        return $object;
    }

    /**
     * @param object $object
     * @param bool $isFlush
     * @return object
     */
    public function remove($object, $isFlush = true)
    {
        $this->_em->remove($object);

        if ($isFlush) {
            $this->flush();
        }

        return $object;
    }

    /**
     * @param $object
     * @return void
     */
    public function persist($object)
    {
        $this->_em->persist($object);
    }

    /**
     * @return void
     */
    public function flush()
    {
        $this->_em->flush();
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->_em->getRepository($this->_entityName);
    }
}