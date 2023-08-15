<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

use App\Models\City;
use App\Models\Company;

use function PHPUnit\Framework\assertNotNull;

class CityTest extends TestCase
{
    use DatabaseTransactions;

    protected $city;
    protected $company_ids = [];

    public function setUpCityWithCompanies(): void
    {
        $this->setUpCity();
        $this->setUpCompanyIds();

        $this->city->addCompanyIds($this->company_ids);
    }

    public function setUpCity(): void
    {
        $name = 'testCity';
        $this->city = City::where('name', $name)->first();
    }

    public function setUpCompanyIds(): void
    {
        $company_names = ['testCompany', 'testCompany2'];
        $this->company_ids = [];

        foreach($company_names as $name) {
            $company = Company::where('name', $name)->first();
            array_push($this->company_ids, $company->id);
        }
    }

    public function testGetCompaniesIdsForEmpty()
    {
        $this->setUpCity();

        $this->assertNotNull($this->city);
        $this->assertIsArray($this->city->getCompanyIds());
        $this->assertEquals($this->city->getCompanyIds(), []);
    }

    public function testAddCompaniesIdForTwoElements()
    {
        $this->setUpCity();
        $this->setUpCompanyIds();

        foreach($this->company_ids as $id)
            $this->city->addCompanyId($id);

        $this->assertNotNull($this->city);
        $this->assertIsArray($this->city->getCompanyIds());
        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }

    public function testAddNonExistingCompaniesId()
    {
        $this->setUpCityWithCompanies();

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->AddCompanyId(23423);

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }

    public function testAddNonExistingCompaniesIdFromEmpty()
    {
        $this->setUpCity();
        $this->company_ids = [];

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->addCompanyId(23423);

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }

    public function testAddNonExistingCompaniesIdsFromEmpty()
    {
        $this->setUpCity();
        $this->company_ids = [];

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->addCompanyIds([23423, 1234]);

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }

    public function testRemoveCompaniesId()
    {
        $this->setUpCityWithCompanies();

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->removeCompanyId($this->company_ids[1]);

        $this->assertEquals($this->city->getCompanyIds(), [$this->company_ids[0]]);
    }

    public function testRemoveCompaniesIds()
    {
        $this->setUpCityWithCompanies();

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->removeCompanyIds([$this->company_ids[1]]);

        $this->assertEquals($this->city->getCompanyIds(), [$this->company_ids[0]]);
    }

    public function testRemoveCompaniesIdsForTwoElements()
    {
        $this->setUpCityWithCompanies();

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->removeCompanyIds($this->company_ids);

        $this->assertEquals($this->city->getCompanyIds(), []);
    }

    public function testRemoveNonExistingCompaniesIds()
    {
        $this->setUpCityWithCompanies();

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->removeCompanyIds([23423, 1234]);

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }

    public function testRemoveNonExistingCompaniesIdsFromEmpty()
    {
        $this->setUpCity();
        $this->company_ids = [];

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);

        $this->city->removeCompanyIds([23423, 1234]);

        $this->assertEquals($this->city->getCompanyIds(), $this->company_ids);
    }
}
