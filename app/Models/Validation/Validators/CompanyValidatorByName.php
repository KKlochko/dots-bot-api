<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\Validator;
use App\Models\Company;

class CompanyValidatorByName extends Validator {
    private string $name;
    protected Validator $nextValidator;

    public function __construct(string $name, Validator $nextValidator)
    {
        $this->name = $name;
        $this->nextValidator = $nextValidator;
    }

    public function isCurrentValid(): bool
    {
        $count = Company::where('name', $this->name)->count();

        return $count != 0;
    }
}

