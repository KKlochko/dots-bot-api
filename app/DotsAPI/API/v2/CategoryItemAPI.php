<?php

namespace App\DotsAPI\API\v2;

use App\DotsAPI\API\v2\AbstractItemAPI;
use App\DotsAPI\API\v2\ItemAPI;
use App\Models\Company;
use App\Models\Category;
use App\Models\Item;

class CategoryItemAPI extends AbstractItemAPI
{
    public function getMap($company_uuid = null) {
        $endpoint = '/api/v2/companies/' . $company_uuid . '/items-by-categories/';

        $categotiesItemsMap = $this->fetcher->get($endpoint);

        return $categotiesItemsMap;
    }

    public function saveMap($categotiesItems, $company = null) {
        foreach ($categotiesItems as $category_json) {
            $uuid = $category_json['id'];
            $name = $category_json['name'];
            $url = $category_json['url'];

            $category = Category::firstOrCreate([
                'uuid' => $uuid,
                'name' => $name,
                'url' => $url,
                'company_id' => $company->id
            ]);

            $item = new ItemAPI($this->fetcher);

            $item->saveMap($category_json['items'], $category);
        }
    }
}

