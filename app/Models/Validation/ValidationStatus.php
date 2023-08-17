<?php

namespace App\Models\Validation;

enum ValidationStatus
{
    case FOUND;
    case NOT_FOUND;
    case INVALID_NAME;

    public function value(): string
    {
        return match($this)
        {
            ValidationStatus::FOUND => 'found',
            ValidationStatus::NOT_FOUND => 'not_found',
            ValidationStatus::INVALID_NAME => 'invalid_name',
        };
    }

    public function status(): string
    {
        return match($this)
        {
            ValidationStatus::FOUND => 'ok',
            ValidationStatus::NOT_FOUND => 'error',
            ValidationStatus::INVALID_NAME => 'error',
        };
    }

    public function isError(): bool
    {
        return $this->status() == 'error';
    }

    public function isOk(): bool
    {
        return $this->status() == 'ok';
    }
}
