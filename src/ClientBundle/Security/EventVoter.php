<?php

namespace ClientBundle\Security;

use ClientBundle\Entity\AbstractEvent;
use ClientBundle\Entity\User;
use ClientBundle\Utils\UserUtils;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class EventVoter extends Voter
{
    protected $permissions = array(
        'delete' => 'canDelete',
    );

    protected function supports($attribute, $subject)
    {
        if (!isset($this->permissions[$attribute])) {
            return false;
        }

        if (!$subject instanceof AbstractEvent) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        $method = $this->permissions[$attribute];

        if (!method_exists($this, $method)) {
            throw new \Exception(sprintf('Method %s not found', $method));
        }

        return call_user_func_array(array($this, $method), array($subject, $user));
    }

    protected function canDelete($subject, User $user)
    {
        return ($user === $subject->getUser() || $user->hasRole('ROLE_ADMIN'));
    }


}