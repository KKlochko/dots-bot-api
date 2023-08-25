<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\ValidationInterface;
use App\Models\Validation\Validators\ValidationTrait;

class UpperRangeValidator implements ValidationInterface {
    private ValidationInterface $nextValidator;
    private int $value;
    private int $rangeLimit;

    public function __construct(int $value, int $rangeLimit, ValidationInterface $nextValidator)
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

    public function isValid(): bool
    {
        return $this->isCurrentValid() && $this->nextValidator->isValid();
    }
}

