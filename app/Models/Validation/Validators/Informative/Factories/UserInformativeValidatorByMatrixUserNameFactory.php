<?php

namespace App\Models\Validation\Validators\Informative\Factories;

use App\Models\Validation\Validators\Informative\Factories\InformativeValidatorByNameFactory;
use App\Models\Validation\Validators\Informative\InformativeValidator;
use App\Models\Validation\Messages\Factories\UsernameMessageByNameFactory;

use App\Models\Validation\Validators\Validator;
use App\Models\Validation\Validators\UserValidatorByMatrixUserName;

class UserInformativeValidatorByMatrixUserNameFactory extends InformativeValidatorByNameFactory
{
    public function __construct(string $name)
    {
        $this->setMessages((new UsernameMessageByNameFactory())->create());

        $this->setName($name);
    }

    public function getValidatorByName(InformativeValidator $okValidator): Validator
    {
        return new UserValidatorByMatrixUserName($this->name, $okValidator);
    }
}

