<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidator;

class UpperRangeValidator extends NextValidator {
    private int $value;
    private int $rangeLimit;
    protected Validator $nextValidator;

    public function __construct(int $value, int $rangeLimit, Validator $nextValidator)
    {
        $this->value = $value;
        $this->rangeLimit = $rangeLimit;
        $this->nextValidator = $nextValidator;
    }

    public function isCurrentValid(): bool
    {
        if($this->value > $this->rangeLimit)
            return false;

        return true;
    }
}

