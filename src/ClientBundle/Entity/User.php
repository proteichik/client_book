<?php

namespace ClientBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Statistic\DoctrineBundle\Entity\Record;

/**
 * Class User
 * @package ClientBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \ClientBundle\Entity\Customer
     *
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="user")
     */
    protected $customers;

    /**
     * @var \ClientBundle\Entity\Call
     *
     * @ORM\OneToMany(targetEntity="Call", mappedBy="user")
     */
    protected $calls;

    /**
     * @var \ClientBundle\Entity\Meeting
     *
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="user")
     */
    protected $meetings;

    /**
     * @var \Statistic\DoctrineBundle\Entity\Record
     *
     * @ORM\OneToMany(targetEntity="Record", mappedBy="user")
     */
    protected $stats;

    public function __construct()
    {
        parent::__construct();
        $this->customers = new ArrayCollection();
        $this->calls = new ArrayCollection();
        $this->meetings = new ArrayCollection();
        $this->stats = new ArrayCollection();
    }

    /**
     * Add customer
     *
     * @param \ClientBundle\Entity\Customer $customer
     *
     * @return User
     */
    public function addCustomer(\ClientBundle\Entity\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \ClientBundle\Entity\Customer $customer
     */
    public function removeCustomer(\ClientBundle\Entity\Customer $customer)
    {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Add call
     *
     * @param \ClientBundle\Entity\Call $call
     *
     * @return User
     */
    public function addCall(\ClientBundle\Entity\Call $call)
    {
        $this->calls[] = $call;

        return $this;
    }

    /**
     * Remove call
     *
     * @param \ClientBundle\Entity\Call $call
     */
    public function removeCall(\ClientBundle\Entity\Call $call)
    {
        $this->calls->removeElement($call);
    }

    /**
     * Get calls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Add meeting
     *
     * @param \ClientBundle\Entity\Meeting $meeting
     *
     * @return User
     */
    public function addMeeting(\ClientBundle\Entity\Meeting $meeting)
    {
        $this->meetings[] = $meeting;

        return $this;
    }

    /**
     * Remove meeting
     *
     * @param \ClientBundle\Entity\Meeting $meeting
     */
    public function removeMeeting(\ClientBundle\Entity\Meeting $meeting)
    {
        $this->meetings->removeElement($meeting);
    }

    /**
     * Get meetings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    /**
     * Add stat
     *
     * @param \ClientBundle\Entity\Record $stat
     *
     * @return User
     */
    public function addStat(\ClientBundle\Entity\Record $stat)
    {
        $this->stats[] = $stat;

        return $this;
    }

    /**
     * Remove stat
     *
     * @param \ClientBundle\Entity\Record $stat
     */
    public function removeStat(\ClientBundle\Entity\Record $stat)
    {
        $this->stats->removeElement($stat);
    }

    /**
     * Get stats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStats()
    {
        return $this->stats;
    }
}
