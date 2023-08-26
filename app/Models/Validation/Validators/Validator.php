<?php

namespace App\Models\Validation\Validators;

abstract class Validator {
    abstract public function isCurrentValid(): bool;

    public function isValid(): bool
    {
        return $this->isCurrentValid() && $this->nextValidator->isValid();
    }
}

