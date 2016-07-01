<?php

namespace ClientBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package ClientBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
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
     * @ORM\OneToMany(targetEntity="Customer", mappedBy="user")
     */
    protected $customers;

    public function __construct()
    {
        parent::__construct();
        $this->customers = new ArrayCollection();
    }

    /**
     * Add customer
     *
     * @param \ClientBundle\Entity\Customer $customer
     *
     * @return User
     */
    public function addCustomer(\ClientBundle\Entity\Customer $customer)
    {
        $this->customers[] = $customer;

        return $this;
    }

    /**
     * Remove customer
     *
     * @param \ClientBundle\Entity\Customer $customer
     */
    public function removeCustomer(\ClientBundle\Entity\Customer $customer)
    {
        $this->customers->removeElement($customer);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }
}
