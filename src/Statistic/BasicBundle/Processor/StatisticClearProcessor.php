<?php

namespace Statistic\BasicBundle\Processor;

use ClientBundle\Entity\Call;
use ClientBundle\Entity\Meeting;

class StatisticClearProcessor extends AbstractProcessor
{
    protected function getActionsList()
    {
        return array(
            Call::class => array(
                'method' => 'decCalls'
            ),
            Meeting::class => array(
                'method' => 'decMeetings'
            ),
        );
    }

}