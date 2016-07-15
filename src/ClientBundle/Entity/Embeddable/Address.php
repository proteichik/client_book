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
     * @ORM\Column(type="integer", unique=true)
     *
     * @Assert\NotBlank()
     * @Assert\Range(min=100000000, max=999999999)
     */
    protected $unp;

    /**
     * Set city
     *
     * @param $city
     * @return $this
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set street
     *
     * @param $street
     * @return $this
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set UNP
     *
     * @param $unp
     * @return $this
     */
    public function setUnp($unp)
    {
        $this->unp = $unp;

        return $this;
    }

    /**
     * Get UNP
     *
     * @return int
     */
    public function getUnp()
    {
        return $this->unp;
    }


}