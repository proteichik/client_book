<?php

namespace ClientBundle\Repository;
/**
 * Class UserRepository
 * @package ClientBundle\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param $id
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersById($id, $isResult = true);

    /**
     * @param $username
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersByUsername($username, $isResult = true);

    /**
     * @param $emailCanonical
     * @param bool $isResult
     * @return \FOS\UserBundle\Model\User|\Doctrine\ORM\QueryBuilder
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getUserWithCustomersByEmail($emailCanonical, $isResult = true);

    /**
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUsersWithCustomers($isResult = true);
}