<?php

namespace ClientBundle\Form;

use ClientBundle\Utils\UserUtils;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

abstract class AbstractExtendedType extends AbstractType
{
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}