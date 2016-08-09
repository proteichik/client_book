<?php

namespace Statistic\BasicBundle\TimeStrategy;

class DailyStrategy implements TimeStrategyInterface
{
    public function convert(\DateTime $date)
    {
        $newDate = new \DateTime($date->format('Y-m-d'));
        $newDate->setTime(0,0,0);

        return $newDate;
    }

}