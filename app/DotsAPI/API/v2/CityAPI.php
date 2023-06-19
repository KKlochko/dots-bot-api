<?php

namespace App\DotsAPI\API\v2;

use App\DotsAPI\API\v2\AbstractItemAPI;
use App\Models\City;

class CityAPI extends AbstractItemAPI
{
    public function getMap($context = null) {
        $endpoint = '/api/v2/cities';

        $citiesMap = $this->fetcher->get($endpoint);

        return $citiesMap;
    }

    public function saveMap($cities, $parent = null) {
        foreach ($cities as $city) {
            $uuid = $city['id'];
            $name = $city['name'];
            $url = $city['url'];

            City::firstOrCreate([
                'uuid' => $uuid,
                'name' => $name,
                'url' => $url
            ]);
        }
    }
}

