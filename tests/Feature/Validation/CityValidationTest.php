<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\City;

class CityValidationTest extends TestCase
{
    public function testCityWithEmptyName(): void
    {
        $json = City::validateWithName('');

        $this->assertEquals($json['error'], 'The city name is empty, please, write the name!!!');
    }

    public function testNotExistingCityWithName(): void
    {
        $name = '404 City';

        $json = City::validateWithName($name);

        $this->assertEquals($json['error'], 'A city with the name does not exist!!!');
    }

    public function testValidCityWithName(): void
    {
        $name = 'testCity';

        $json = City::validateWithName($name);

        $this->assertEquals($json['ok'], 'A city with the name is valid.');
    }
}
