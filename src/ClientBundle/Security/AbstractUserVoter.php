<?php

namespace ClientBundle\Security;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

abstract class AbstractUserVoter extends Voter
{
    /**
     * @var array
     */
    protected $actions = array();

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
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
}