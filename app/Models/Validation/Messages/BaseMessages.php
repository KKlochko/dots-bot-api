<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\ValidationStatus;

class BaseMessages
{
    protected array $messages;

    public function __construct($messages)
    {
        $this->messages = $messages;
    }

    public function getMessage($status): string
    {
        return match($status)
        {
            ValidationStatus::FOUND => $this->messages['found'],
            ValidationStatus::NOT_FOUND => $this->messages['not_found'],
            ValidationStatus::INVALID_NAME => $this->messages['invalid_name'],
        };
    }
}
