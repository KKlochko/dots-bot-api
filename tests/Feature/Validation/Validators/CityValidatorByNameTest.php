<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\CityValidatorByName;
use App\Models\Validation\Validators\OkValidator;

class CityValidatorByNameTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'isValid' =>  false,
            ],
            'Not Found Case' => [
                'name' => '404 City',
                'isValid' =>  false,
            ],
            'Found Case' => [
                'name' => 'testCity',
                'isValid' =>  true,
            ]
        ];
    }

    public function setUpValidator(string $name): CityValidatorByName
    {
        return new CityValidatorByName($name, new OkValidator());
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
