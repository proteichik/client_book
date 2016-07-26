<?php

namespace ClientBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ConstraintNearEventValidator extends ConstraintValidator
{
    protected $countDays;

    public function __construct($countDays = 3)
    {
        $this->countDays = $countDays;
    }

    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }

        if (!$value instanceof \DateTime) {
            throw new UnexpectedTypeException($value, 'DateTime');
        }

        $date = new \DateTime('-' . $this->countDays . ' days');

        if ($value < $date) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }

}