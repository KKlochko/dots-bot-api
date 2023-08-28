<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\InformativeValidatorFactory;
use App\Models\Validation\Messages\InformativeValidator;

use App\Models\Validation\Messages\OkInformativeValidator;
use App\Models\Validation\Messages\NextInformativeValidator;
use App\Models\Validation\Validators\EmptyNameValidator;
use App\Models\Validation\Validators\ItemValidatorByName;

class ItemInformativeValidatorByNameFactory extends InformativeValidatorFactory
{
    protected array $messages;
    protected string $name;

    public function __construct(string $name)
    {
        $this->messages = [
            'found' => 'A item with the name is valid.',
            'not_found' => 'A item with the name does not exist!!!',
            'invalid_name' => 'The item name is empty, please, write the name!!!',
        ];

        $this->name = $name;
    }

    function create(): InformativeValidator
    {
        $okValidator = new OkInformativeValidator($this->messages['found']);

        $nameValidator = new NextInformativeValidator(
            $this->messages['not_found'],
            new ItemValidatorByName($this->name, $okValidator),
            $okValidator
        );

        return new NextInformativeValidator(
            $this->messages['invalid_name'],
            new EmptyNameValidator($this->name, $nameValidator),
            $nameValidator
        );
    }
}

