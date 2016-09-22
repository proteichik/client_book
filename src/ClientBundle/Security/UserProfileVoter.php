<?php

namespace ClientBundle\Security;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserProfileVoter extends AbstractUserVoter
{
    protected $actions = array(
        'showProfile',
    );

    protected $roles = array(
        'ROLE_SUPER_ADMIN',
    );

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        $roles = array_intersect($this->roles, $user->getRoles());

        if ($subject->getId() === $user->getId() || count($roles) > 0) {
            return true;
        }

        return false;
    }

}