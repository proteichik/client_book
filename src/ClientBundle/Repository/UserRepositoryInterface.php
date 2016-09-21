<?php

namespace ClientBundle\Repository;

/**
 * Class UserRepository
 * @package ClientBundle\Repository
 */
interface UserRepositoryInterface
{
    public function getCountCustomers($id, array $options = array());
}