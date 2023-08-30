<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidator;

class OkValidator extends NextValidator {
    public function isCurrentValid(): bool
    {
        return true;
    }

    public function isValid(): bool
    {
        return true;
    }
}

