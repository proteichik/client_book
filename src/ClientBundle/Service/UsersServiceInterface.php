<?php

namespace ClientBundle\Service;

interface UsersServiceInterface
{
    public function findAllUsers(array $options = array(), $isResult = true);
}