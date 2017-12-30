<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class MyDate extends Constraint
{
    public $message = 'You can\'t enter a date in the future. "{{ string }}".';
}
