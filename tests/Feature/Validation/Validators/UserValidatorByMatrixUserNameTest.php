<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\UserValidatorByMatrixUserName;
use App\Models\Validation\Validators\OkValidator;

class UserValidatorByMatrixUserNameTest extends TestCase
{
    public function dataProvider() {
        return [
            'Found Case' => [
                'name' => '@test:test.com',
                'isValid' => true,
            ],
            'Not Found Case' => [
                'name' => '@kostia:test.com',
                'isValid' => false,
            ],
            'Invalid Case' => [
                'name' => '',
                'isValid' => false,
            ],
        ];
    }

    public function setUpValidator(string $name): UserValidatorByMatrixUserName
    {
        return new UserValidatorByMatrixUserName($name, new OkValidator());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetMessage(string $name, bool $isValid): void
    {
        $validator = $this->setUpValidator($name);

        $this->assertEquals($validator->isValid(), $isValid);
    }
}

