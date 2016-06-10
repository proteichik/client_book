<?php

namespace ClientBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Customer
 * @package ClientBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="customer")
 */
class Customer
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
     * @var string
     *
     * @ORM\Column(type="string", length=150)
     *
     * @Assert\NotBlank()
     */
    protected $company;

    /**
     * @var ClientBundle\Entity\Embeddable\Address
     *
     * @ORM\Embedded(class="ClientBundle\Entity\Embeddable\Address")
     *
     * @Assert\Type(type="ClientBundle\Entity\Embeddable\Address")
     * @Assert\Valid()
     */
    protected $address;

    /**
     * @var ClientBundle\Entity\Embeddable\Contacts
     *
     * @ORM\Embedded(class="ClientBundle\Entity\Embeddable\Contacts")
     *
     * @Assert\Type(type="ClientBundle\Entity\Embeddable\Contacts")
     * @Assert\Valid()
     */
    protected $contacts;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $info;

    /**
     * @var ClientBundle\Entity\Call[]
     *
     * @ORM\OneToMany(targetEntity="Call", mappedBy="customer")
     *
     */
    protected $calls;

    /**
     * @var ClientBundle\Entity\Meeting[]
     *
     * @ORM\OneToMany(targetEntity="Meeting", mappedBy="customer")
     */
    protected $meetings;

    /**
     * @var ClientBundle\Entity\Manager
     *
     * @ORM\ManyToOne(targetEntity="Manager", inversedBy="customers")
     * @ORM\JoinColumn(name="manager_id", referencedColumnName="id")
     *
     * @Assert\Type(type="ClientBundle\Entity\Manager")
     * @Assert\Valid()
     */
    protected $manager;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->calls = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }
}