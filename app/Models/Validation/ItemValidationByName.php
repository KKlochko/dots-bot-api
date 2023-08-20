<?php

namespace App\Models\Validation;

use App\Models\Validation\ModelValidationByName;
use App\Models\Validation\Messages\ItemMessagesFactory;

class ItemValidationByName extends ModelValidationByName
{
    public function __construct(string $name)
    {
        parent::__construct(
            $name,
            'App\Models\Item',
            (new ItemMessagesFactory())->create(),
        );
    }
}
