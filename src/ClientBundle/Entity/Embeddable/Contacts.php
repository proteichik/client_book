<?php

namespace ClientBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contacts
 * @package ClientBundle\Entity\Embeddable
 *
 * @ORM\Embeddable
 */
class Contacts
{
    /**
     * @var string;
     *
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $work;

    /**
     * @var string;
     *
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $mobile;

    /**
     * @var string;
     *
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    protected $fax;

    /**
     * @var string;
     *
     * @ORM\Column(type="string", length=250, nullable=true)
     *
     * @Assert\Email();
     */
    protected $email;
}