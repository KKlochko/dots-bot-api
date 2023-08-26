<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\InformativeValidator;
use App\Models\Validation\Validators\UpperRangeValidator;

class UpperRangeInformativeValidator extends InformativeValidator {
    protected InformativeValidator $nextValidator;

    public function __construct(string $message, UpperRangeValidator $validator, InformativeValidator $nextValidator)
    {
        $this->setMessage($message);
        $this->setValidator($validator);
        $this->nextValidator = $nextValidator;
    }
}

