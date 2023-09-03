<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\Validators\Informative\Factories\CompanyInformativeValidatorByNameFactory;

class CompanyInformativeValidatorByNameFactoryTest extends TestCase
{
    public function dataProvider() {
        return [
            'Found Case' => [
                'name' => 'testCompany',
                'key' => 'ok',
                'message' => 'A company with the name is valid.',
                'isValid' => true,
            ],
            'Not Found Case' => [
                'name' => '404 Company',
                'key' => 'error',
                'message' => 'A company with the name does not exist!!!',
                'isValid' => false,
            ],
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' => 'The company name is empty, please, write the name!!!',
                'isValid' => false,
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testValidatorFactory(string $name, string $key, string $message, bool $isValid): void
    {
        $factory = new CompanyInformativeValidatorByNameFactory($name);
        $validator = $factory->create();

        $this->assertEquals($validator->getMessage(), $message);
        $this->assertEquals($validator->getOkStatus(), [$key => $message]);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
