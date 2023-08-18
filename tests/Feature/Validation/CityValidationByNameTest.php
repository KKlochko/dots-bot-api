<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\CityValidationByName;

class CityValidationByNameTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' =>  'The city name is empty, please, write the name!!!',
                'isValid' =>  false,
            ],
            'Not Found Case' => [
                'name' => '404 City',
                'key' => 'error',
                'message' =>  'A city with the name does not exist!!!',
                'isValid' =>  false,
            ],
            'Found Case' => [
                'name' => 'testCity',
                'key' => 'ok',
                'message' =>  'A city with the name is valid.',
                'isValid' =>  true,
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCityValidationWithName(string $name, string $key, string $message, bool $isValid): void
    {
        $validator = new CityValidationByName($name);
        $json = $validator->getMessageMap();

        $this->assertEquals($json[$key], $message);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
