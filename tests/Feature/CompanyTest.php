<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Company;

class CompanyTest extends TestCase
{
    public function testIsExistForExistingCompany()
    {
        $name = 'testCompany';
        $id = Company::where('name', $name)->first()->id;

        $isExist = Company::isExist($id);

        $this->assertTrue($isExist);
    }

    public function testIsExistForNonExistingCompany()
    {
        $id = 1234;

        $isExist = Company::isExist($id);

        $this->assertFalse($isExist);
    }
}
