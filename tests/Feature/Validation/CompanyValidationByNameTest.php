<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\CompanyValidationByName;

class CompanyValidationByNameTest extends TestCase
{
    public function dataProvider() {
        return [
            'Invalid Case' => [
                'name' => '',
                'key' => 'error',
                'message' => 'The company name is empty, please, write the name!!!',
                'isValid' => false,
            ],
            'Not Found Case' => [
                'name' => '404 Company',
                'key' => 'error',
                'message' => 'A company with the name does not exist!!!',
                'isValid' => false,
            ],
            'Found Case' => [
                'name' => 'testCompany',
                'key' => 'ok',
                'message' => 'A company with the name is valid.',
                'isValid' => true,
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCompanyValidationWithName(string $name, string $key, string $message, bool $isValid): void
    {
        $validator = new CompanyValidationByName($name);
        $json = $validator->getMessageMap();

        $this->assertEquals($json[$key], $message);
        $this->assertEquals($validator->isValid(), $isValid);
    }
}
