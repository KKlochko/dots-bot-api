<?php

namespace App\Models\Validation\Validators;

abstract class Validator {
    abstract public function isValid(): bool;
}

