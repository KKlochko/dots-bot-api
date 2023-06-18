<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    protected $test_companies = [
        [
            'uuid' => 'b7301b09-fc0c-4d0d-a556-ed70fc8e40f7',
            'name' => 'testCompany',
            'image' => null,
            'description' => 'Pellentesque tristique imperdiet tortor.'
        ],
        [
            'uuid' => 'b7301b09-fc0c-4d0d-a546-ed70fc8e40f7',
            'name' => 'testCompany2',
            'image' => null,
            'description' => 'Curabitur vulputate vestibulum lorem.'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach($this->test_companies as $test_company)
            Company::factory()->create($test_company);
    }
}
