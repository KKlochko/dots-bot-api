<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\InformativeValidator;

abstract class InformativeValidatorFactory
{
    abstract function create(): InformativeValidator;
}

