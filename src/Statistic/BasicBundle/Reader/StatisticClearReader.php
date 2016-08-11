<?php

namespace Statistic\BasicBundle\Reader;

use ClientBundle\Entity\AbstractEvent;

class StatisticClearReader extends AbstractReader
{
    /**
     * @return array
     */
    public function getItems()
    {
        return $this->getRepository()->getRemovedAndProcessedEvents();
    }

    /**
     * @param AbstractEvent $item
     */
    public function markProcess(AbstractEvent $item)
    {
        $item->setProcessed(0);
    }

}