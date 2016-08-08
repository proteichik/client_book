<?php

namespace Statistic\MongoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Statistic\BasicBundle\Model\User as BaseUser;

/**
 * Class User
 * @package Statistic\MongoBundle\Document
 *
 * @MongoDB\Document
 */
class User extends BaseUser
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceMany(targetDocument="Record", cascade="all")
     */
    protected $records;


    public function __construct()
    {
        $this->records = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param Record $record
     */
    public function addStat(\Statistic\MongoBundle\Document\Record $record)
    {
        $this->records[] = $record;
    }

    /**
     * @param Record $record
     */
    public function removeStat(\Statistic\MongoBundle\Document\Record $record)
    {
        $this->records->removeElement($record);
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStats()
    {
        return $this->records;
    }
}
