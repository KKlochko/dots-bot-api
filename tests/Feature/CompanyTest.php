<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Company;

class CompanyTest extends TestCase
{
    /* company validation */

    public function test_company_with_empty_name(): void
    {
        $json = Company::validate_with_name('');

        $this->assertEquals($json['error'], 'The company name is empty, please, write the name!!!');
    }

    public function test_not_existing_company_with_name(): void
    {
        $name = '404 Company';

        $json = Company::validate_with_name($name);

        $this->assertEquals($json['error'], 'A company with the name does not exist!!!');
    }

    public function test_valid_company_with_name(): void
    {
        $name = 'testCompany';

        $json = Company::validate_with_name($name);

        $this->assertEquals($json['ok'], 'A company with the name is valid.');
    }
}
