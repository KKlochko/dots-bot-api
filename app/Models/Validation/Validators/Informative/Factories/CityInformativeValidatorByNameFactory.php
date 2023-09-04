<?php

namespace App\Models\Validation\Validators\Informative\Factories;

use App\Models\Validation\Validators\Informative\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Validators\Informative\InformativeValidator;
use App\Models\Validation\Messages\Factories\MessageByNameFactory;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\CityValidatorByName;

class CityInformativeValidatorByNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages((new MessageByNameFactory('city'))->create());

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new CityValidatorByName($this->name, $okValidator);
    }
}

