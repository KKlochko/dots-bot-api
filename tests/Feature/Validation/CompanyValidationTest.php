<?php

namespace Tests\Feature;

use Tests\TestCase;

use App\Models\Company;

class CompanyValidationTest extends TestCase
{
    public function testCompanyWithEmptyName(): void
    {
        $json = Company::validateWithName('');

        $this->assertEquals($json['error'], 'The company name is empty, please, write the name!!!');
    }

    public function testNotExistingCompanyWithName(): void
    {
        $name = '404 Company';

        $json = Company::validateWithName($name);

        $this->assertEquals($json['error'], 'A company with the name does not exist!!!');
    }

    public function testValidCompanyWithName(): void
    {
        $name = 'testCompany';

        $json = Company::validateWithName($name);

        $this->assertEquals($json['ok'], 'A company with the name is valid.');
    }
}
