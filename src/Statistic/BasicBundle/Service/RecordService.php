<?php

namespace Statistic\BasicBundle\Service;

use ClientBundle\Model\EntityInterface;
use ClientBundle\Service\ServiceInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Statistic\BasicBundle\Repository\RecordRepositoryInterface;

class RecordService implements ServiceInterface
{
    const TYPE_CALL = 'call';
    const TYPE_MEETING = 'meeting';

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
     * @return \Statistic\BasicBundle\Repository\RecordRepositoryInterface;
     */
    public function getRepository()
    {
        $repository = $this->_em->getRepository($this->_entityName);

        if (!$repository instanceof RecordRepositoryInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Repository must be instance of %s',
                RecordRepositoryInterface::class
            ));
        }

        return $repository;
    }

    public function delete(EntityInterface $object, $isFlush = true)
    {
        return $this->remove($object, $isFlush);
    }

    public function getQueryBuilder($alias)
    {
        return $this->getRepository()->createQueryBuilder($alias);
    }

    public function getAggregateInfoByEvent($type)
    {
        switch ($type)
        {
            case self::TYPE_CALL:
                return $this->getRepository()->getAggregateInfoCalls();
                break;
            case self::TYPE_MEETING:
                return $this->getRepository()->getAggregateInfoMeetings();
                break;
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Not found aggregate function for type %s',
                    $type
                ));
        }
    }
    
    public function getInfoByTypeForColumnChart($type)
    {
        switch ($type)
        {
            case self::TYPE_CALL:
                return $this->getRepository()->getCallsInfoForColumn();
                break;
            case self::TYPE_MEETING:
                return $this->getRepository()->getMeetingsInfoForColumn();
                break;
            default:
                throw new \InvalidArgumentException(sprintf(
                    'Not found aggregate function for type %s',
                    $type
                ));
        }
    }

}