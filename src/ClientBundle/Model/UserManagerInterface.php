<?php

namespace ClientBundle\Model;

use FOS\UserBundle\Model\UserManagerInterface as BaseInterface;

interface UserManagerInterface extends BaseInterface
{
    /**
     * @param $id
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder 
     */
    public function getUserWithCustomersById($id, $isResult = true);

    /**
     * @param $username
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUserWithCustomersByUsername($username, $isResult = true);

    /**
     * @param $emailCanonical
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUserWithCustomersByEmail($emailCanonical, $isResult = true);

    /**
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUsersWithCustomers($isResult = true);
}