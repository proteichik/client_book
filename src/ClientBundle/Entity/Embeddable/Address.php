<?php

namespace ClientBundle\Entity\Embeddable;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Address
 * @package ClientBundle\Entity\Embeddable
 *
 * @ORM\Embeddable
 */
class Address
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    protected $city;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250)
     *
     * @Assert\NotBlank()
     */
    protected $street;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank()
     * @Assert\Range(min=100000000, max=999999999)
     */
    protected $unp;
}