<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\InformativeValidator;
use App\Models\Validation\Validators\OkValidator;

class OkInformativeValidator extends InformativeValidator {
    public function __construct($message)
    {
        $this->message = $message;
        $this->validator = new OkValidator();
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getOkStatus(): array
    {
        return ['ok' => $this->getMessage()];
    }
}

