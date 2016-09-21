<?php
namespace ClientBundle\Model;

use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface as BaseInterface;

/**
 * Class UserManager
 * @package ClientBundle\Service
 */
interface UserManagerInterface extends BaseInterface
{
    /**
     * @param UserInterface $user
     * @return int
     */
    public function getCountCustomersByUser(UserInterface $user);
}