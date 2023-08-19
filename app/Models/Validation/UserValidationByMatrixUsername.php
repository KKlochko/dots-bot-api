<?php

namespace App\Models\Validation;

use App\Models\Validation\ModelValidationByName;
use App\Models\Validation\Messages\UserMessagesFactory;

class UserValidationByMatrixUsername extends ModelValidationByName
{
    public function __construct(string $name)
    {
        parent::__construct(
            $name,
            'App\Models\User',
            (new UserMessagesFactory())->create(),
        );
    }
}
