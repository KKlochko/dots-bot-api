<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\BaseMessages;

class UserMessagesFactory
{
    protected array $messages = [
        'found' => 'A user with the username is valid.',
        'not_found' => 'A user with the username does not exist!!!',
        'invalid_name' => 'The username is empty, please, write username!!!',
    ];

    public function create()
    {
        return new BaseMessages($this->messages);
    }
}

