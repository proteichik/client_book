<?php

namespace Statistic\MongoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class User
 * @package Statistic\MongoBundle\Document
 *
 * @MongoDB\Document
 */
class User
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Statistic", cascade="all")
     */
    protected $stats;


    public function __construct()
    {
        $this->stats = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add stat
     *
     * @param Statistic\MongoBundle\Document\Statistic $stat
     */
    public function addStat(\Statistic\MongoBundle\Document\Statistic $stat)
    {
        $this->stats[] = $stat;
    }

    /**
     * Remove stat
     *
     * @param Statistic\MongoBundle\Document\Statistic $stat
     */
    public function removeStat(\Statistic\MongoBundle\Document\Statistic $stat)
    {
        $this->stats->removeElement($stat);
    }

    /**
     * Get stats
     *
     * @return \Doctrine\Common\Collections\Collection $stats
     */
    public function getStats()
    {
        return $this->stats;
    }
}
