<?php

namespace App\Models\Validation\Messages;

use App\Models\Validation\Messages\BaseMessages;

class CompanyMessagesFactory
{
    protected array $messages = [
        'found' => 'A company with the name is valid.',
        'not_found' => 'A company with the name does not exist!!!',
        'invalid_name' => 'The company name is empty, please, write the name!!!',
    ];

    public function create()
    {
        return new BaseMessages($this->messages);
    }
}

