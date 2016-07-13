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
     * is valid status
     *
     * @Assert\IsTrue(message="Вы не можете запланировать cобытие в прошлом")
     *
     * @return bool
     */
    public function isValidStatus()
    {
        $now = new \DateTime();

        return ($this->date < $now && $this->status == self::PLANNED_TYPE) ? false : true;
    }
}