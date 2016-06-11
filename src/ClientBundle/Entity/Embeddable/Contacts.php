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

    /**
     * Set work phone number
     *
     * @param $work
     * @return $this
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * Get work phone number
     *
     * @return string
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Set mobile phone number
     *
     * @param $mobile
     * @return $this
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile phone number
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set fax number
     *
     * @param $fax
     * @return $this
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax number
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email address
     *
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}