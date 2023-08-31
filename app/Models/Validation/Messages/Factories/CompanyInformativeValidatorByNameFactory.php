<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Messages\InformativeValidator;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\CompanyValidatorByName;

class CompanyInformativeValidatorByNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages([
            'found' => 'A company with the name is valid.',
            'not_found' => 'A company with the name does not exist!!!',
            'invalid_name' => 'The company name is empty, please, write the name!!!',
        ]);

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new CompanyValidatorByName($this->name, $okValidator);
    }
}

