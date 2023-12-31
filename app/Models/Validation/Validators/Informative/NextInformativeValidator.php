<?php

namespace App\Models\Validation\Validators\Informative;

use App\Models\Validation\Validators\Informative\InformativeValidator;
use App\Models\Validation\Validators\Validator;

class NextInformativeValidator extends InformativeValidator {
    protected InformativeValidator $nextValidator;

    public function __construct(string $message, Validator $validator, InformativeValidator $nextValidator)
    {
        $this->setMessage($message);
        $this->setValidator($validator);
        $this->nextValidator = $nextValidator;
    }
}
