<?php

namespace ClientBundle\Entity;

use ClientBundle\Model\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Validator\Constraints as ClientAssert;

/**
 * Class AbstractEvent
 * @package ClientBundle\Entity
 */
abstract class AbstractEvent implements EntityInterface
{
    const PLANNED_TYPE = 1;
    const DONE_TYPE = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     * @ClientAssert\ConstraintNearEvent()
     */
    protected $date;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     *
     */
    protected $status;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $info;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $alias;

    /**
     * @var \ClientBundle\Entity\Customer
     */
    protected $customer;

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return $this
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set status
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set info
     *
     * @param $info
     * @return $this
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get created date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @ORM\PrePersist
     */
    public function setAlias()
    {
        $this->alias = $this->customer->getId() . '-' . $this->date->getTimestamp();
    }

    /**
     * is valid status
     *
     * @Assert\IsTrue(message="Вы не можете запланировать cобытие в прошлом")
     *
     * @return bool
     */
    public function isValidStatus()
    {
        $now = new \DateTime();
        $now->modify("+ 5 minutes");

        return ($this->date < $now && $this->status === self::PLANNED_TYPE) ? false : true;
    }

    /**
     * Совершенное событие не может быть в будующем
     *
     * @Assert\IsFalse(message="Неправильная дата!")
     * @return bool
     */
    public function isNoFutureDoneEvent()
    {
        $now = new \DateTime();

        return ($this->status == self::DONE_TYPE && $this->date > $now);
    }

    /**
     * @return bool
     */
    public function isDoneEvent()
    {
        return ($this->status === self::DONE_TYPE);
    }
}