<?php

namespace App\Models\Validation;

use App\Models\Validation\ValidationByNameInterface;
use App\Models\Validation\ValidationStatus;
use App\Models\Validation\Messages\BaseMessages;

class ModelValidationByName
{
    protected static BaseMessages $messages;
    protected static string $className;
    protected string $name;

    public function __construct(string $name, string $className, BaseMessages $messages)
    {
        if (!in_array('App\Models\Validation\ValidationByNameInterface', class_implements($className)))
            throw new \RuntimeException("$className does not implement the ValidationByNameInterface interface.");

        $this->name = $name;
        static::$className = $className;
        static::$messages = $messages;
    }

    public function getStatus()
    {
        if(!call_user_func([static::$className, 'isNameValid'], $this->name))
            return ValidationStatus::INVALID_NAME;

        if(!call_user_func([static::$className, 'isExistByName'], $this->name))
            return ValidationStatus::NOT_FOUND;

        return ValidationStatus::FOUND;
    }

    public function getMessageMap()
    {
        $status = $this->getStatus();

        return [
            $status->status() => static::$messages->getMessage($status)
        ];
    }

    public function isValid()
    {
        return $this->getStatus()->isOk();
    }
}

