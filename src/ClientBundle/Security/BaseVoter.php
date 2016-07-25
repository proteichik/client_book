<?php

namespace ClientBundle\Security;

use ClientBundle\Entity\User;
use ClientBundle\Model\EntityInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class BaseVoter extends Voter
{
    protected $permissions = array(
        'delete' => 'canDelete',
    );

    protected function supports($attribute, $subject)
    {
        if (!isset($this->permissions[$attribute])) {
            return false;
        }

        if (!$subject instanceof EntityInterface) {
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
        if (!method_exists($subject, 'getUser')) {
            throw new \LogicException('Method getUser() does not exists.');
        }

        return ($user === $subject->getUser() || $user->hasRole('ROLE_ADMIN'));
    }


}