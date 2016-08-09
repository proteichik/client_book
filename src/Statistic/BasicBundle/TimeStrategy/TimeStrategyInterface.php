<?php

namespace Statistic\BasicBundle\TimeStrategy;

interface TimeStrategyInterface
{
    public function convert(\DateTime $date);
}