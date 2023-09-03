<?php

namespace App\Models\Validation\Validators\Informative\Factories;

use App\Models\Validation\Validators\Informative\InformativeValidator;

abstract class InformativeValidatorFactory
{
    abstract function create(): InformativeValidator;
}

