<?php

namespace App\DotsAPI\API\v2;

use App\DotsAPI\API\v2\AbstractItemAPI;
use App\Models\Company;

class CompanyAPI extends AbstractItemAPI
{
    public function getMap($city_uuid = null) {
        $endpoint = '/api/v2/cities/' . $city_uuid . '/companies/';

        $companiesMap = $this->fetcher->get($endpoint);

        return $companiesMap;
    }

    public function saveMap($companies, $city = null) {
        foreach ($companies as $company) {
            $uuid = $company['id'];
            $name = $company['name'];
            $image = $company['image'] ?? '';
            $description = $company['description'] ?? '';

            Company::firstOrCreate([
                'uuid' => $uuid,
                'name' => $name,
                'image' => $image,
                'description' => $description,
            ]);
        }
    }
}
