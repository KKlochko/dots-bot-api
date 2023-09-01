<?php

namespace App\Models\Validation\Messages\Factories;

use App\Models\Validation\Messages\Factories\MessageFactory;

class MessageByNameFactory extends MessageFactory
{
    private string $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function create(): array
    {
        return [
            'found' => "A $this->name with the name is valid.",
            'not_found' => "A $this->name with the name does not exist!!!",
            'invalid_name' => "The $this->name name is empty, please, write the name!!!",
        ];
    }
}

