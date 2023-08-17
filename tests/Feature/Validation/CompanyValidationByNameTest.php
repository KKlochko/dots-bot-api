<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Validation\CompanyValidationByName;

class CompanyValidationByNameTest extends TestCase
{
    public function testCompanyWithEmptyName(): void
    {
        $name = '';

        $validator = new CompanyValidationByName($name);
        $json = $validator->getMessageMap();
        $isValid = $validator->isValid();

        $this->assertEquals($json['error'], 'The company name is empty, please, write the name!!!');
        $this->assertFalse($isValid);
    }

    public function testNotExistingCompanyWithName(): void
    {
        $name = '404 Company';

        $validator = new CompanyValidationByName($name);
        $json = $validator->getMessageMap();
        $isValid = $validator->isValid();

        $this->assertEquals($json['error'], 'A company with the name does not exist!!!');
        $this->assertFalse($isValid);
    }

    public function testValidCompanyWithName(): void
    {
        $name = 'testCompany';

        $validator = new CompanyValidationByName($name);
        $json = $validator->getMessageMap();
        $isValid = $validator->isValid();

        $this->assertEquals($json['ok'], 'A company with the name is valid.');
        $this->assertTrue($isValid);
    }
}
