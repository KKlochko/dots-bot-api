<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\Validators\EmptyNameValidator;
use App\Models\Validation\Validators\OkValidator;

class EmptyNameValidatorTest extends TestCase
{
    public function dataProvider() {
        return [
            'Valid Case' => [
                'name' => 'name',
                'isValid' => true,
            ],
            'Invalid Case' => [
                'name' => '',
                'isValid' => false,
            ],
        ];
    }

    public function setUpValidator(string $name): EmptyNameValidator
    {
        return new EmptyNameValidator($name, new OkValidator());
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
