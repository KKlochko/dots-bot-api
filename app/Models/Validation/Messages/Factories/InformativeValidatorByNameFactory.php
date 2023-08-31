<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\InformativeValidatorFactory;
use App\Models\Validation\Messages\InformativeValidator;

use App\Models\Validation\Messages\OkInformativeValidator;
use App\Models\Validation\Messages\NextInformativeValidator;
use App\Models\Validation\Validators\EmptyNameValidator;
use App\Models\Validation\Validators\Validator;

abstract class InformativeValidatorByNameFactory extends InformativeValidatorFactory
{
    protected array $messages;
    protected string $name;

    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getValidatorByName(InformativeValidator $okValidator): Validator;

    public function create(): InformativeValidator
    {
        $okValidator = new OkInformativeValidator($this->messages['found']);

        $nameValidator = new NextInformativeValidator(
            $this->messages['not_found'],
            $this->getValidatorByName($okValidator),
            $okValidator
        );

        return new NextInformativeValidator(
            $this->messages['invalid_name'],
            new EmptyNameValidator($this->name, $nameValidator),
            $nameValidator
        );
    }
}

