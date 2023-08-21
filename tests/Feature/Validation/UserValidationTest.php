<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\UserValidationByMatrixUsername;

class UserValidationTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' =>  'The username is empty, please, write username!!!',
                'isValid' =>  false,
            ],
            'Not Found Case' => [
                'name' => '@kostia:test.com',
                'key' => 'error',
                'message' =>  'A user with the username does not exist!!!',
                'isValid' =>  false,
            ],
            'Found Case' => [
                'name' => '@test:test.com',
                'key' => 'ok',
                'message' =>  'A user with the username is valid.',
                'isValid' =>  true,
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testUserValidationWithName(string $name, string $key, string $message, bool $isValid): void
    {
        $validator = new UserValidationByMatrixUsername($name);
        $json = $validator->getMessageMap();

        $this->assertEquals($json[$key], $message);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
