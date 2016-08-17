<?php

namespace ClientBundle\Factory\Charts;

interface ChartsFactoryInterface
{
    public function getChart(array $data, array $options = array());
}