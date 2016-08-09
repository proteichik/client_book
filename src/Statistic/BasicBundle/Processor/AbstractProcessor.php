<?php

namespace Statistic\BasicBundle\Processor;

use Doctrine\Common\Persistence\ObjectManager;
use Statistic\BasicBundle\TimeStrategy\TimeStrategyInterface;
use Statistic\BasicBundle\Traits\CacheTrait;

abstract class AbstractProcessor implements ProcessorInterface
{
    use CacheTrait;

    /**
     * @var ObjectManager
     */
    protected $_em;

    /**
     * @var TimeStrategyInterface
     */
    protected $_timeStrategy;

    /**
     * AbstractProcessor constructor.
     * @param ObjectManager $em
     * @param TimeStrategyInterface $timeStrategy
     */
    public function __construct(ObjectManager $em, TimeStrategyInterface $timeStrategy)
    {
        $this->_em = $em;
        $this->_timeStrategy = $timeStrategy;
    }

    /**
     * @return ObjectManager
     */
    public function getEntityManager()
    {
        return $this->_em;
    }

    /**
     * @param ObjectManager $em
     * @return $this
     */
    public function setEntityManager(ObjectManager $em)
    {
        $this->_em = $em;

        return $this;
    }

    /**
     * @return TimeStrategyInterface
     */
    public function getTimeStrategy()
    {
        return $this->_timeStrategy;
    }

    /**
     * @param TimeStrategyInterface $timeStrategy
     * @return $this
     */
    public function setTimeStrategy(TimeStrategyInterface $timeStrategy)
    {
        $this->_timeStrategy = $timeStrategy;

        return $this;
    }

    protected function getStaticEntity($item)
    {
        $key = $item->getUser()->getId() . '-' . $item->getDate()->format('Y-m-d');
    }
}