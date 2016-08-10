<?php

namespace Statistic\BasicBundle\Event;

use ClientBundle\Model\EntityInterface;
use Statistic\BasicBundle\Model\Record;
use Symfony\Component\EventDispatcher\Event;

class ProcessEvent extends Event
{
    const NAME = 'statistic.process';

    /**
     * @var \ClientBundle\Model\EntityInterface
     */
    protected $item;

    /**
     * @var \Statistic\BasicBundle\Model\Record
     */
    protected $record;

    /**
     * ProcessEvent constructor.
     * @param \ClientBundle\Model\EntityInterface $item
     * @param \Statistic\BasicBundle\Model\Record $record
     */
    public function __construct(EntityInterface $item, Record $record)
    {
        $this->item = $item;
        $this->record = $record;
    }

    /**
     * @return EntityInterface
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * @param EntityInterface $item
     * @return $this
     */
    public function setItem(EntityInterface $item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * @return Record
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * @param Record $record
     * @return $this
     */
    public function setRecord(Record $record)
    {
        $this->record = $record;

        return $this;
    }




}