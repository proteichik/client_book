<?php

namespace ClientBundle\Service;

use ClientBundle\Repository\UserRepositoryInterface;
use FOS\UserBundle\Doctrine\UserManager as BaseManager;
use ClientBundle\Model\UserManagerInterface;

/**
 * Class UserManager
 * @package ClientBundle\Service
 */
class UserManager extends BaseManager implements UserManagerInterface
{
    /**
     * @param $id
     * @param bool $isResult
     * @return \Doctrine\ORM\QueryBuilder|\FOS\UserBundle\Model\User
     */
    public function getUserWithCustomersById($id, $isResult = true)
    {
        return $this->getRepository()->getUserWithCustomersById($id, $isResult);
    }

    /**
     * @param $username
     * @param bool $isResult
     * @return \Doctrine\ORM\QueryBuilder|\FOS\UserBundle\Model\User
     */
    public function getUserWithCustomersByUsername($username, $isResult = true)
    {
        return $this->getRepository()->getUserWithCustomersByUsername($username, $isResult);
    }

    /**
     * @param $emailCanonical
     * @param bool $isResult
     * @return \Doctrine\ORM\QueryBuilder|\FOS\UserBundle\Model\User
     */
    public function getUserWithCustomersByEmail($emailCanonical, $isResult = true)
    {
        return $this->getRepository()->getUserWithCustomersByEmail($emailCanonical, $isResult);
    }

    /**
     * @param bool $isResult
     * @return array|\Doctrine\ORM\QueryBuilder
     */
    public function getUsersWithCustomers($isResult = true)
    {
        return $this->getRepository()->getUsersWithCustomers($isResult);
    }

    /**
     * @return UserRepositoryInterface
     */
    protected function getRepository()
    {
        if (!$this->repository instanceof UserRepositoryInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Repository class must implements %s', UserRepositoryInterface::class
            ));
        }

        return $this->repository;
    }
}