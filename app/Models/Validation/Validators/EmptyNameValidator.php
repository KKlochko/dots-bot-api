<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidator;

class EmptyNameValidator extends NextValidator {
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
