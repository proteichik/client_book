<?php

namespace Statistic\BasicBundle\Processor;

use ClientBundle\Entity\Call;
use ClientBundle\Entity\Meeting;

class StatisticAddProcessor extends AbstractProcessor
{
    protected function getActionsList()
    {
        return array(
            Call::class => array(
                'method' => 'incCalls'
            ),
            Meeting::class => array(
                'method' => 'incMeetings'
            ),
        );
    }

}