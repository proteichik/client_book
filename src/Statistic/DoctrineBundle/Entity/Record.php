<?php

namespace Statistic\DoctrineBundle\Entity;

use Statistic\BasicBundle\Model\Record as BaseRecord;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Entity\User;

/**
 * Class Record
 * @package Statistic\DoctrineBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="statistic")
 */
class Record extends BaseRecord
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
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\NotBlank()
     * @Assert\DateTime()
     */
    protected $date;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    protected $countCalls = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    protected $countMeetings = 0;

    /**
     * @var BaseUser
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="stats")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="ClientBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;
}
