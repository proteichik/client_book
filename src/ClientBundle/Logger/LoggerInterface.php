<?php

namespace ClientBundle\Logger;

interface LoggerInterface
{
    public function info($message, array $context = array());
    public function error($message, array $context = array());
    public function warning($message, array $context = array());
}