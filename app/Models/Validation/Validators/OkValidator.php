<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\ValidationInterface;

class OkValidator implements ValidationInterface {
    public function isValid(): bool
    {
        return true;
    }
}

