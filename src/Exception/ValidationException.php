<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

class ValidationException extends \Exception
{
    /**
     * This contains validation errors (violations).
     *
     */
    private $violations;

    public function __construct($violations = null)
    {
        $this->violations = $violations;
        parent::__construct('Validation failed');
    }

    public function getInfoMessage()
    {
        return $this->violations->__toString();
    }

    public function getErrors(): array
    {
        $errorData = [];
        foreach ($this->violations as $violation) {
            $errorData[] = [
                "parameter" => $violation->getPropertyPath(),
                "message" => $violation->getMessage()
            ];
        }
        return $errorData;
    }
}
