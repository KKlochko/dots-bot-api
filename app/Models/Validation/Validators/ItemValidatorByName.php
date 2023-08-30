<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidatorByName;
use App\Models\Item;

class ItemValidatorByName extends NextValidatorByName {
    public function isCurrentValid(): bool
    {
        $count = Item::where('name', $this->getName())->count();

        return $count != 0;
    }
}

