<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Meeting
 * @package ClientBundle\Entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="meetings")
 */
class Meeting extends AbstractEvent
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
     * @var ClientBundle\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="meetings")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     * @Assert\Type(type="ClientBundle\Entity\Customer")
     * @Assert\Valid()
     */
    protected $customer;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set customer
     *
     * @param \ClientBundle\Entity\Customer $customer
     *
     * @return Meeting
     */
    public function setCustomer(\ClientBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \ClientBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}
