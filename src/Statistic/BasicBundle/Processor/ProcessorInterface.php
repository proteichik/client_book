<?php

namespace Statistic\BasicBundle\Processor;

use ClientBundle\Entity\AbstractEvent;

interface ProcessorInterface
{
    public function process(AbstractEvent $item);

    public function save($statObject, $isFlush = false);

    public function flush();
}