<?php

namespace App\Models\Validation;

use App\Models\Validation\ModelValidationByName;
use App\Models\Validation\Messages\CityMessagesFactory;

class CityValidationByName extends ModelValidationByName
{
    public function __construct(string $name)
    {
        parent::__construct(
            $name,
            'App\Models\City',
            (new CityMessagesFactory())->create(),
        );
    }
}
