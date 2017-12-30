<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MyDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $value = $value->format('Y-m-d');
        if (strtotime($value) > time()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
