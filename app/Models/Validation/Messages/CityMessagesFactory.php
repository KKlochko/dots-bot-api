<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\BaseMessages;

class CityMessagesFactory
{
    protected array $messages = [
        'found' => 'A city with the name is valid.',
        'not_found' => 'A city with the name does not exist!!!',
        'invalid_name' => 'The city name is empty, please, write the name!!!',
    ];

    public function create()
    {
        return new BaseMessages($this->messages);
    }
}

