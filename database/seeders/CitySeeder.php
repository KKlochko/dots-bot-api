<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    protected $test_cities = [
        [
            'uuid' => 'b7307b09-fc0c-4d0d-a556-ed70fc8e40f7',
            'name' => 'testCity',
            'url' => 'test_city'
        ],
        [
            'uuid' => 'b7307b09-fc0c-4d0d-a556-ed50fc8e40f7',
            'name' => 'testCity2',
            'url' => 'test_city2'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory()
            ->count(10)
            ->create();

        foreach($this->test_cities as $test_city)
            City::factory()->create($test_city);
    }
}
