<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    protected Company $test_company;

    protected $test_category = [
        'uuid' => 'b7301b09-fc1c-4d0d-a556-ed70fc8e40f7',
        'name' => 'Pizza',
        'url' => 'pizza',
        'company_id' => null
    ];

    public function setTestCompany()
    {
        $this->test_company = Company::firstOrCreate([
            'name' => 'testCompany',
        ]);

        $this->test_category['company_id'] = $this->test_company->id;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setTestCompany();
        Category::factory()->create($this->test_category);
    }
}
