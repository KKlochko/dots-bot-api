<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidatorByName;
use App\Models\City;

class CityValidatorByName extends NextValidatorByName
{
    public function isCurrentValid(): bool
    {
        $count = City::where('name', $this->getName())->count();

        return $count != 0;
    }
}
