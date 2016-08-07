<?php

namespace Statistic\MongoBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Statistic
 * @package Statistic\MongoBundle
 *
 * @MongoDB\Document
 */
class Statistic
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDb\Field(type="date")
     */
    protected $date;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $countCalls = 0;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $countMeetings = 0;

    /**
     * @MongoDB\ReferenceOne(targetDocument="User", inversedBy="stats")
     */
    protected $user;

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
     * Set date
     *
     * @param date $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return date $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set countCalls
     *
     * @param int $countCalls
     * @return $this
     */
    public function setCountCalls($countCalls)
    {
        $this->countCalls = $countCalls;
        return $this;
    }

    /**
     * Get countCalls
     *
     * @return int $countCalls
     */
    public function getCountCalls()
    {
        return $this->countCalls;
    }

    /**
     * Set countMeetings
     *
     * @param int $countMeetings
     * @return $this
     */
    public function setCountMeetings($countMeetings)
    {
        $this->countMeetings = $countMeetings;
        return $this;
    }

    /**
     * Get countMeetings
     *
     * @return int $countMeetings
     */
    public function getCountMeetings()
    {
        return $this->countMeetings;
    }

    /**
     * Set user
     *
     * @param Statistic\MongoBundle\Document\User $user
     * @return $this
     */
    public function setUser(\Statistic\MongoBundle\Document\User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return Statistic\MongoBundle\Document\User $user
     */
    public function getUser()
    {
        return $this->user;
    }
}
