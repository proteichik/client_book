<?php

namespace Statistic\BasicBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;

class Record
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $countCalls = 0;

    /**
     * @var int
     */
    protected $countMeetings = 0;
    
    /**
     * @var BaseUser
     */
    protected $user;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountCalls()
    {
        return $this->countCalls;
    }

    /**
     * @param int $countCalls
     * @return $this
     */
    public function setCountCalls($countCalls)
    {
        $this->countCalls = $countCalls;

        return $this;
    }

    /**
     * @return int
     */
    public function getCountMeetings()
    {
        return $this->countMeetings;
    }

    /**
     * @param int $countMeetings
     * @return $this
     */
    public function setCountMeetings($countMeetings)
    {
        $this->countMeetings = $countMeetings;

        return $this;
    }

    /**
     * @return BaseUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param BaseUser $user
     * @return $this
     */
    public function setUser(BaseUser $user)
    {
        $this->user = $user;

        return $this;
    }

    public function incCalls()
    {
        $this->countCalls++;
    }

    public function decCalls()
    {
        if ($this->countCalls === 0) {
            throw new \RuntimeException('Can\'t dec. Calls count = 0');
        }

        $this->countCalls--;
    }

    public function decMeetings()
    {
        if ($this->countMeetings === 0) {
            throw new \RuntimeException('Can\'t dec. Meetings count = 0');
        }

        $this->countMeetings--;
    }

    public function incMeetings()
    {
        $this->countMeetings++;
    }
}