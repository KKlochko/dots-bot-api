<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\Validator;

class OkValidator extends Validator {
    public function isCurrentValid(): bool
    {
        return true;
    }

    public function isValid(): bool
    {
        return true;
    }
}

