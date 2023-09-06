<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\Informative\Factories\UserInformativeValidatorByMatrixUserNameFactory;

class UserInformativeValidatorByMatrixUserNameFactoryTest extends TestCase
{
    public function dataProvider() {
        return [
            'Found Case' => [
                'name' => '@test:test.com',
                'key' => 'ok',
                'message' => 'A user with the username is valid.',
                'isValid' => true,
            ],
            'Not Found Case' => [
                'name' => '@kostia:test.com',
                'key' => 'error',
                'message' => 'A user with the username does not exist!!!',
                'isValid' => false,
            ],
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' => 'The username is invalid, please, check that you are registered or signed in!!!',
                'isValid' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidatorFactory(string $name, string $key, string $message, bool $isValid): void
    {
        $factory = new UserInformativeValidatorByMatrixUserNameFactory($name);
        $validator = $factory->create();

        $this->assertEquals($validator->getMessage(), $message);
        $this->assertEquals($validator->getOkStatus(), [$key => $message]);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}

