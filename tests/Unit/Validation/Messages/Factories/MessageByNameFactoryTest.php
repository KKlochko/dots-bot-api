<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Messages\Factories\MessageByNameFactory;

class MessageByNameFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $name = 'company';
        $expected_messages = [
            'found' => "A company with the name is valid.",
            'not_found' => "A company with the name does not exist!!!",
            'invalid_name' => "The company name is empty, please, write the name!!!",
        ];

        $factory = new MessageByNameFactory($name);

        $this->assertEquals($factory->create(), $expected_messages);
    }
}

