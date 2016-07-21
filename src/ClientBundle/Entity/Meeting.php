<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Annotation\CustomerSelect;

/**
 * Class Meeting
 * @package ClientBundle\Entity
 *
 * @ORM\Entity(repositoryClass="ClientBundle\Repository\EventRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="meetings")
 * @CustomerSelect(idField="customer_id")
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
     * @var \ClientBundle\Entity\Customer
     *
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="meetings")
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *
     * @Assert\Type(type="ClientBundle\Entity\Customer")
     * @Assert\Valid()
     */
    protected $customer;

    /**
     * @var \ClientBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="meetings")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Assert\Type(type="ClientBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

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
