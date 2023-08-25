<?php

namespace App\Models\Validation\Validators;

interface ValidationInterface {
    public function isValid(): bool;
}

