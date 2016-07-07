<?php

namespace ClientBundle\Form\DataTransformer;

use ClientBundle\Utils\UserUtils;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CurrentUserTransformer implements DataTransformerInterface
{
    protected $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    public function transform($user)
    {
        $user = $this->getUser();

        if (!$user){
            return null;
        }

        return $user->getId();
    }

    public function reverseTransform($id)
    {
        return $this->getUser();
    }

    protected function getUser()
    {
        return UserUtils::getUser($this->tokenStorage);
    }
}