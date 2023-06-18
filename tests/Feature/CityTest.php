<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\City;

class CityTest extends TestCase
{
    /* City validation */

    public function test_city_with_empty_name(): void
    {
        $json = City::validate_with_name('');

        $this->assertEquals($json['error'], 'The city name is empty, please, write the name!!!');
    }

    public function test_not_existing_city_with_name(): void
    {
        $name = '404 City';

        $json = City::validate_with_name($name);

        $this->assertEquals($json['error'], 'A city with the name does not exist!!!');
    }

    public function test_valid_city_with_name(): void
    {
        $name = 'testCity';

        $json = City::validate_with_name($name);

        $this->assertEquals($json['ok'], 'A city with the name is valid.');
    }
}
