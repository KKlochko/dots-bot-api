<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\ItemValidatorByName;
use App\Models\Validation\Validators\OkValidator;

class ItemValidatorByNameTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'isValid' =>  false,
            ],
            'Not Found Case' => [
                'name' => '404 Item',
                'isValid' =>  false,
            ],
            'Found Case' => [
                'name' => 'Pizza Polo',
                'isValid' =>  true,
            ]
        ];
    }

    public function setUpValidator(string $name): ItemValidatorByName
    {
        return new ItemValidatorByName($name, new OkValidator());
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
