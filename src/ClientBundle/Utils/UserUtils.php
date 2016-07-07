<?php

namespace ClientBundle\Utils;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserUtils
 * @package ClientBundle\Utils
 */
class UserUtils
{
    /**
     * @param TokenStorageInterface $tokenStorage
     * @return UserInterface|null
     */
    public static function getUser(TokenStorageInterface $tokenStorage)
    {
        $token = $tokenStorage->getToken();

        if (!$token) {
            return null;
        }

        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return null;
        }

        return $user;
    }
}