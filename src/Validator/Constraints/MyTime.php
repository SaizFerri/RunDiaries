<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MyTime extends Constraint
{
    public $message = 'The time can\'t be 0."{{ string }}".';
}
