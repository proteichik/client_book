<?php

namespace Statistic\BasicBundle\Reader;

use ClientBundle\Entity\AbstractEvent;

interface ReaderInterface
{
    public function getItems();

    public function markProcess(AbstractEvent $item);

    public function saveItem(AbstractEvent $item, $isFlush = true);

    public function flush();
}