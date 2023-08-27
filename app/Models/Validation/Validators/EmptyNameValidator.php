<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\Validator;

class EmptyNameValidator extends Validator {
    private string $name;
    protected Validator $nextValidator;

    public function __construct(string $name, Validator $nextValidator)
    {
        $this->name = $name;
        $this->nextValidator = $nextValidator;
    }

    public function isCurrentValid(): bool
    {
        return $this->name != "";
    }
}
