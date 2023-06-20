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
        foreach ($companies as $company_json) {
            $uuid = $company_json['id'];
            $name = $company_json['name'];
            $image = $company_json['image'] ?? '';
            $description = $company_json['description'] ?? '';

            $company = Company::firstOrCreate([
                'uuid' => $uuid,
                'name' => $name,
                'image' => $image,
                'description' => $description,
            ]);

            if($city != null)
                $city->addCompanyId($company->id);
        }
    }
}
