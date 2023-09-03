<?php

namespace App\Models\Validation\Validators\Informative\Factories;

use App\Models\Validation\Validators\Informative\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Validators\Informative\InformativeValidator;
use App\Models\Validation\Messages\Factories\MessageByNameFactory;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\CompanyValidatorByName;

class CompanyInformativeValidatorByNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages((new MessageByNameFactory('company'))->create());

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new CompanyValidatorByName($this->name, $okValidator);
    }
}

