<?php
namespace Verifactu\Models;

use Symfony\Component\Validator\Validation;
use Verifactu\Exceptions\InvalidModelException;

abstract class Model {
    /**
     * Validate this instance
     */
    final public function validate(): void {
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $errors = $validator->validate($this);
        if (count($errors) > 0) {
            throw new InvalidModelException($errors);
        }
    }
}
