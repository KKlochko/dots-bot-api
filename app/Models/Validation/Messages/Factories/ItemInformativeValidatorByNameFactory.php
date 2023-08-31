<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Messages\InformativeValidator;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\ItemValidatorByName;

class ItemInformativeValidatorByNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages([
            'found' => 'A item with the name is valid.',
            'not_found' => 'A item with the name does not exist!!!',
            'invalid_name' => 'The item name is empty, please, write the name!!!',
        ]);

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new ItemValidatorByName($this->name, $okValidator);
    }
}

