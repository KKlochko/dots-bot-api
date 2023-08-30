<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidatorByName;
use App\Models\Company;

class CompanyValidatorByName extends NextValidatorByName {
    public function isCurrentValid(): bool
    {
        $count = Company::where('name', $this->getName())->count();

        return $count != 0;
    }
}

