<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\Informative\Factories\ItemInformativeValidatorByNameFactory;

class ItemInformativeValidatorByNameFactoryTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' =>  'The item name is empty, please, write the name!!!',
                'isValid' =>  false,
            ],
            'Not Found Case' => [
                'name' => '404 Item',
                'key' => 'error',
                'message' =>  'A item with the name does not exist!!!',
                'isValid' =>  false,
            ],
            'Found Case' => [
                'name' => 'Pizza Polo',
                'key' => 'ok',
                'message' =>  'A item with the name is valid.',
                'isValid' =>  true,
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidatorFactory(string $name, string $key, string $message, bool $isValid): void
    {
        $factory = new ItemInformativeValidatorByNameFactory($name);
        $validator = $factory->create();

        $this->assertEquals($validator->getMessage(), $message);
        $this->assertEquals($validator->getOkStatus(), [$key => $message]);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
