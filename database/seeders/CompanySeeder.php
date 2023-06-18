<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    protected $test_company = [
        'uuid' => 'b7301b09-fc0c-4d0d-a556-ed70fc8e40f7',
        'name' => 'testCompany',
        'image' => null,
        'description' => 'Pellentesque tristique imperdiet tortor.'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::factory()->create($this->test_company);
    }
}
