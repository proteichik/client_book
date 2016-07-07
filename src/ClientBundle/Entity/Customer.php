<?php

namespace ClientBundle\Entity;

use ClientBundle\Model\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use ClientBundle\Annotation\UserAware;

/**
 * Class Customer
 * @package ClientBundle\Entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="customer")
 *
 * @UserAware(userFieldName="user_id")
 */
class Customer implements EntityInterface
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
     * @ORM\Column(type="text", nullable=true)
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
     * @var ClientBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="customers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @Assert\Type(type="ClientBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date")
     *
     */
    protected $createdAt;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->calls = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }

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
     * Set company
     *
     * @param string $company
     *
     * @return Customer
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Customer
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

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set address
     *
     * @param \ClientBundle\Entity\Embeddable\Address $address
     *
     * @return Customer
     */
    public function setAddress(\ClientBundle\Entity\Embeddable\Address $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \ClientBundle\Entity\Embeddable\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set contacts
     *
     * @param \ClientBundle\Entity\Embeddable\Contacts $contacts
     *
     * @return Customer
     */
    public function setContacts(\ClientBundle\Entity\Embeddable\Contacts $contacts)
    {
        $this->contacts = $contacts;

        return $this;
    }

    /**
     * Get contacts
     *
     * @return \ClientBundle\Entity\Embeddable\Contacts
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add call
     *
     * @param \ClientBundle\Entity\Call $call
     *
     * @return Customer
     */
    public function addCall(\ClientBundle\Entity\Call $call)
    {
        $this->calls[] = $call;

        return $this;
    }

    /**
     * Remove call
     *
     * @param \ClientBundle\Entity\Call $call
     */
    public function removeCall(\ClientBundle\Entity\Call $call)
    {
        $this->calls->removeElement($call);
    }

    /**
     * Get calls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Add meeting
     *
     * @param \ClientBundle\Entity\Meeting $meeting
     *
     * @return Customer
     */
    public function addMeeting(\ClientBundle\Entity\Meeting $meeting)
    {
        $this->meetings[] = $meeting;

        return $this;
    }

    /**
     * Remove meeting
     *
     * @param \ClientBundle\Entity\Meeting $meeting
     */
    public function removeMeeting(\ClientBundle\Entity\Meeting $meeting)
    {
        $this->meetings->removeElement($meeting);
    }

    /**
     * Get meetings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMeetings()
    {
        return $this->meetings;
    }

    /**
     * Set user
     *
     * @param \ClientBundle\Entity\User $user
     *
     * @return Customer
     */
    public function setUser(\ClientBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ClientBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
