<?php

namespace Statistic\BasicBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PreProcessEvent extends Event
{
    const NAME = 'statistic.pre_process';

    /**
     * @var array
     */
    protected $items;

    /**
     * @param $items
     */
    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }
}