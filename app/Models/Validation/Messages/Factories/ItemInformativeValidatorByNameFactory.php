<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Messages\Factories\MessageByNameFactory;
use App\Models\Validation\Messages\InformativeValidator;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\ItemValidatorByName;

class ItemInformativeValidatorByNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages((new MessageByNameFactory('item'))->create());

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new ItemValidatorByName($this->name, $okValidator);
    }
}

