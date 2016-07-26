<?php

namespace ClientBundle\Entity;

use ClientBundle\Model\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Validator\Constraints as ClientAssert;

/**
 * Class AbstractEvent
 * @package ClientBundle\Entity
 */
abstract class AbstractEvent extends BaseEntity
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
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $processed = false;

    /**
     * @var \ClientBundle\Entity\User
     */
    protected $user;

    public function __construct()
    {
        $this->status = self::DONE_TYPE;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

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
     * @return boolean
     */
    public function isProcessed()
    {
        return $this->processed;
    }

    /**
     * @param $processed
     * @return $this
     * @return $this
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * is valid status
     *
     * @Assert\IsFalse(message="Вы не можете запланировать cобытие в прошлом")
     *
     * @return bool
     */
    public function isValidStatus()
    {
        $now = new \DateTime();
        $now->modify("+ 5 minutes");

        return ($this->date < $now && (int) $this->status === self::PLANNED_TYPE);
    }

    /**
     * Совершенное событие не может быть в будующем
     *
     * @Assert\IsFalse(message="Неправильная дата!", groups={"creation"})
     * @return bool
     */
    public function isNoFutureDoneEventCreation()
    {
        $now = new \DateTime();

        return ((int) $this->status === self::DONE_TYPE && $this->date > $now);
    }

    /**
     * При активации события дата должна быть сегодняшней
     *
     * @Assert\IsFalse(message="Неправильная дата!", groups={"activate"})
     * @return bool
     */
    public function isNoFutureDoneEventActivate()
    {
        $now = new \DateTime();

        $now->setTime(23, 59, 59);
        return ((int) $this->status === self::DONE_TYPE && $this->date > $now);
    }

    /**
     * @return bool
     */
    public function isDoneEvent()
    {
        return ((int) $this->status === self::DONE_TYPE);
    }
}