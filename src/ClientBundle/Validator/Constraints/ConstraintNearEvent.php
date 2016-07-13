<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * Class ConstraintsNearEvent
 * @package ClientBundle\Validator\Constraints
 */
class ConstraintNearEvent extends Constraint
{
    public $message = 'Дата выходит за границы диапазона';
}