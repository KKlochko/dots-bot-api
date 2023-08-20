<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\BaseMessages;

class ItemMessagesFactory
{
    protected array $messages = [
        'found' => 'A item with the name is valid.',
        'not_found' => 'A item with the name does not exist!!!',
        'invalid_name' => 'The item name is empty, please, write the name!!!',
    ];

    public function create()
    {
        return new BaseMessages($this->messages);
    }
}

