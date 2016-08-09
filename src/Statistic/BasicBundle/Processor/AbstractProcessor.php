<?php

namespace Statistic\BasicBundle\Processor;

use ClientBundle\Entity\AbstractEvent;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Model\User;
use Statistic\BasicBundle\Model\Record;
use Statistic\BasicBundle\TimeStrategy\TimeStrategyInterface;
use Statistic\BasicBundle\Traits\CacheTrait;

abstract class AbstractProcessor implements ProcessorInterface
{
    use CacheTrait;

    /**
     * @var ObjectManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_entityClass;

    /**
     * @var TimeStrategyInterface
     */
    protected $_timeStrategy;

    /**
     * @param ObjectManager $em
     * @param string $entityClass
     * @param TimeStrategyInterface $timeStrategy
     */
    public function __construct(ObjectManager $em, $entityClass, TimeStrategyInterface $timeStrategy)
    {
        $this->_em = $em;
        $this->setEntityClass($entityClass);
        $this->_timeStrategy = $timeStrategy;
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
    public function getEntityClass()
    {
        return $this->_entityClass;
    }

    /**
     * @param string $entityClass
     */
    public function setEntityClass($entityClass)
    {
        if (!is_string($entityClass)) {
            throw new \InvalidArgumentException('Entity class must be a string');
        }

        $this->_entityClass = $entityClass;
    }

    /**
     * @return TimeStrategyInterface
     */
    public function getTimeStrategy()
    {
        return $this->_timeStrategy;
    }

    /**
     * @param TimeStrategyInterface $timeStrategy
     * @return $this
     */
    public function setTimeStrategy(TimeStrategyInterface $timeStrategy)
    {
        $this->_timeStrategy = $timeStrategy;

        return $this;
    }

    /**
     * @param AbstractEvent $item
     * @return Record
     */
    public function process(AbstractEvent $item)
    {
        $statObject = $this->getStatisticEntity($item);

        $action = $this->getAction($item);

        call_user_func($statObject, $action['method']);

        return $statObject;
    }

    /**
     * @param AbstractEvent $item
     * @return Record
     */
    protected function getStatisticEntity(AbstractEvent $item)
    {
        $date = $this->_timeStrategy->convert($item->getDate());
        $user = $item->getUser();

        $key = $date->format('Y-m-d') . '-' . $user->getId();
        if ($this->inCache($key)) {
            $object = $this->getFromCache($key);
        } else {
            $object = $this->getRepository()->findOneBy(array('date' => $date, 'user' => $user));
        }

        if (!$object) {
            $object = new Record();
            $object->setDate($date);
            $object->setUser($user);
        }

        $this->setToCache($key, $object);

        return $object;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    protected function getRepository()
    {
        return $this->_em->getRepository($this->_entityClass);
    }

    /**
     * @param $item
     * @return array
     */
    protected function getAction($item)
    {
        $actions = $this->getActionsList();

        if (!isset($actions[get_class($item)])) {
            throw new \InvalidArgumentException(sprintf('Can\'t find action for class $s', get_class($item)));
        }

        return $actions[get_class($item)];
    }

    /**
     * @param $statObject
     * @param bool|false $isFlush
     */
    public function save($statObject, $isFlush = false)
    {
        $this->_em->persist($statObject);

        if ($isFlush) {
            $this->flush();
        }
    }

    public function flush()
    {
        $this->_em->flush();
    }

    abstract protected function getActionsList();


}