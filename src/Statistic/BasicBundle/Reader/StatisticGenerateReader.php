<?php

namespace Statistic\BasicBundle\Reader;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Repository\EventRepository;
use Doctrine\Common\Persistence\ObjectManager;

class StatisticGenerateReader implements ReaderInterface
{
    /**
     * @var ObjectManager
     */
    protected $_em;

    /**
     * @var string
     */
    protected $_entityName;

    public function __construct(ObjectManager $em, $entityName)
    {
        $this->_em = $em;
        $this->setEntityName($entityName);
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
     */
    public function setEntityManager(ObjectManager $em)
    {
        $this->_em = $em;
    }

    /**
     * @return mixed
     */
    public function getEntityName()
    {
        return $this->_entityName;
    }

    /**
     * @param mixed $entityName
     */
    public function setEntityName($entityName)
    {
        if (!is_string($entityName)) {
            throw new \InvalidArgumentException('Entity name must be a string');
        }

        $this->_entityName = $entityName;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->getRepository()->getUnProcessEvents();
    }

    public function markProcess(AbstractEvent $item)
    {
        $item->setProcessed(1);
    }

    /**
     * @param AbstractEvent $item
     * @param bool $isFlush
     * @return AbstractEvent
     */
    public function saveItem(AbstractEvent $item, $isFlush = true)
    {
        $this->_em->persist($item);

        if ($isFlush) {
            $this->flush();
        }

        return $item;
    }
    
    
    public function flush()
    {
        $this->_em->flush();
    }

    /**
     * @return \ClientBundle\Repository\EventRepository
     */
    protected function getRepository()
    {
        $repository = $this->_em->getRepository($this->_entityName);

        if (! $repository instanceof EventRepository) {
            throw new \InvalidArgumentException('Repository must be instance of EventRepository');
        }

        return $repository;
    }

}