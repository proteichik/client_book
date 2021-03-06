<?php

namespace ClientBundle\Security;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserManipulatorVoter extends AbstractUserVoter
{
    protected $actions = array(
        'canDelete',
        'canLock',
    );

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }
        
        if ($subject->getId() === $user->getId()) {
            return false;
        }

        return true;
    }

}