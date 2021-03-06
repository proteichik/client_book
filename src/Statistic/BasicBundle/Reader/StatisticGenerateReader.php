<?php

namespace Statistic\BasicBundle\Reader;

use ClientBundle\Entity\AbstractEvent;

class StatisticGenerateReader extends AbstractReader
{
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
}