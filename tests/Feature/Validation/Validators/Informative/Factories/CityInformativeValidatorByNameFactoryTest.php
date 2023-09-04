<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\Informative\Factories\CityInformativeValidatorByNameFactory;

class CityInformativeValidatorByNameFactoryTest extends TestCase
{
    public function dataProvider() {
        return [
            'Found Case' => [
                'name' => 'testCity',
                'key' => 'ok',
                'message' => 'A city with the name is valid.',
                'isValid' => true,
            ],
            'Not Found Case' => [
                'name' => '404 City',
                'key' => 'error',
                'message' => 'A city with the name does not exist!!!',
                'isValid' => false,
            ],
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' => 'The city name is empty, please, write the name!!!',
                'isValid' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidatorFactory(string $name, string $key, string $message, bool $isValid): void
    {
        $factory = new CityInformativeValidatorByNameFactory($name);
        $validator = $factory->create();

        $this->assertEquals($validator->getMessage(), $message);
        $this->assertEquals($validator->getOkStatus(), [$key => $message]);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}

