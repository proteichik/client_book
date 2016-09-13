<?php

namespace ClientBundle\Security;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserManipulatorVoter extends Voter
{
    protected $actions = array(
        'canDelete',
        'canLock',
    );

    protected function supports($attribute, $subject)
    {
        if (!in_array($attribute, $this->actions)) {
            return false;
        }

        // only vote on Post objects inside this voter
        if (!$subject instanceof UserInterface) {
            return false;
        }

        return true;

    }

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