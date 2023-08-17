<?php

namespace App\Models\Validation;

use App\Models\Validation\ModelValidationByName;
use App\Models\Validation\Messages\CompanyMessagesFactory;

class CompanyValidationByName extends ModelValidationByName
{
    public function __construct(string $name)
    {
        parent::__construct(
            $name,
            'App\Models\Company',
            (new CompanyMessagesFactory())->create(),
        );
    }
}
