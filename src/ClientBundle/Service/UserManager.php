<?php

namespace ClientBundle\Service;

use ClientBundle\Repository\UserRepositoryInterface;
use FOS\UserBundle\Doctrine\UserManager as BaseManager;
use ClientBundle\Model\UserManagerInterface;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class UserManager
 * @package ClientBundle\Service
 */
class UserManager extends BaseManager implements UserManagerInterface
{
    public function getCountCustomersByUser(UserInterface $user)
    {
        $key = 'countCustomers';
        $result = $this->getRepository()->getCountCustomers($user->getId(),
            array('key' => $key)
        );

        return $result[$key];
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