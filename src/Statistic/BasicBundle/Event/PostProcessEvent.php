<?php

namespace Statistic\BasicBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class PostProcessEvent extends Event
{
    const NAME = 'statistic.post_process';
}