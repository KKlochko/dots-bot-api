<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidator;

abstract class NextValidatorByName extends NextValidator {
    private string $name;

    public function __construct(string $name, Validator $nextValidator)
    {
        $this->setName($name);
        $this->setNextValidator($nextValidator);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function isCurrentValid(): bool;
}

