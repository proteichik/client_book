<?php

namespace Statistic\BasicBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class StatisticService
{
    /**
     * @var ObjectManager
     */
    protected $readerManager;

    /**
     * @var ObjectManager
     */
    protected $writerManager;

    /**
     * @var string
     */
    protected $eventClass;

    /**
     * @param ObjectManager $reader
     * @param ObjectManager $writer
     * @param string $eventClass
     */
    public function __construct(ObjectManager $reader, ObjectManager $writer, $eventClass)
    {
        $this->readerManager = $reader;
        $this->writerManager = $writer;
        $this->setEventClass($eventClass);
    }

    /**
     * @return ObjectManager
     */
    public function getReaderManager()
    {
        return $this->readerManager;
    }

    /**
     * @param ObjectManager $readerManager
     * @return $this
     */
    public function setReaderManager(ObjectManager $readerManager)
    {
        $this->readerManager = $readerManager;

        return $this;
    }

    /**
     * @return ObjectManager
     */
    public function getWriterManager()
    {
        return $this->writerManager;
    }

    /**
     * @param ObjectManager $writerManager
     * @return $this
     */
    public function setWriterManager(ObjectManager $writerManager)
    {
        $this->writerManager = $writerManager;

        return $this;
    }

    /**
     * @return string
     */
    public function getEventClass()
    {
        return $this->eventClass;
    }

    /**
     * @param string $eventClass
     * @return $this
     */
    public function setEventClass($eventClass)
    {
        if (!is_string($eventClass)) {
            throw new InvalidTypeException('Event class must be a string');
        }

        $this->eventClass = $eventClass;

        return $this;
    }

    /**
     * @return \ClientBundle\Entity\AbstractEvent[]
     */
    public function getItemsForProcess()
    {
        return $this->readerManager->getRepository($this->eventClass)->getUnProcessEvents();
    }
}