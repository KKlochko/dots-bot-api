<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\ItemValidationByName;

class ItemValidationByNameTest extends TestCase
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
    public function testItemValidationWithName(string $name, string $key, string $message, bool $isValid): void
    {
        $validator = new ItemValidationByName($name);
        $json = $validator->getMessageMap();

        $this->assertEquals($json[$key], $message);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
