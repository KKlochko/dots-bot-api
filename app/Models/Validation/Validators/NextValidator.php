<?php

namespace App\Models\Validation\Validators;
use App\Models\Validation\Validators\Validator;

abstract class NextValidator extends Validator {
    protected Validator $nextValidator;

    public function setNextValidator(Validator $validator): void
    {
        $this->nextValidator = $validator;
    }

    public function getNextValidator(): Validator
    {
        return $this->nextValidator;
    }

    abstract public function isCurrentValid(): bool;

    public function isValid(): bool
    {
        return $this->isCurrentValid() && $this->getNextValidator()->isValid();
    }
}

