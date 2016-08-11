<?php

namespace Statistic\DoctrineBundle\Factory;

use Statistic\BasicBundle\Factory\AbstractCommandFactory;

class StatisticClearFactory extends AbstractCommandFactory
{
    /**
     * @param string $type
     * @return object
     */
    public function getReader($type)
    {
        $reader = null;
        switch ($type)
        {
            case 'call':
                $reader = $this->get('statistic.doctrine.reader.doctrine_reader_clear_call');
                break;
            case 'meeting':
                $reader = $this->get('statistic.doctrine.reader.doctrine_reader_clear_meeting');
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Not found reader for type %s', $type));
        }

        return $reader;
    }

    /**
     * @return object
     */
    public function getProcessor()
    {
        return $this->get('statistic.doctrine.processor.doctrine_clear_processor');
    }

}