<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\MessageFactory;

class UsernameMessageByNameFactory extends MessageFactory
{
    public function create(): array
    {
        return [
            'found' => "A user with the username is valid.",
            'not_found' => "A user with the username does not exist!!!",
            'invalid_name' => "The username is invalid, please, check that you are registered or signed in!!!",
        ];
    }
}

