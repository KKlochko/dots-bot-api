<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Validators\Validator;

abstract class InformativeValidator extends Validator {
    protected Validator $validator;
    protected string $message;

    public function isCurrentValid(): bool
    {
        return $this->validator->isCurrentValid();
    }

    public function isValid(): bool
    {
        return $this->validator->isValid();
    }

    public function setValidator($validator): void
    {
        $this->validator = $validator;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        if(!$this->isCurrentValid())
            return $this->message;

        return $this->nextValidator->getMessage();
    }

    public function okStatus(): array
    {
        if(!$this->isCurrentValid())
            return ['error' => $this->message];

        return $this->nextValidator->okStatus();
    }
}

