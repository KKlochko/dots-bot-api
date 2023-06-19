<?php

namespace App\DotsAPI\API\v2;

use App\DotsAPI\API\v2\AbstractItemAPI;
use App\Models\Item;

class ItemAPI extends AbstractItemAPI
{
    public function getMap($category_uuid = null) {
        //
    }

    public function saveMap($items, $category = null) {
        foreach ($items as $item) {
            $uuid = $item['id'];
            $name = $item['name'];
            $url = $item['url'];
            $description = $item['description'] ?? '';
            $price = $item['price'] ?? 0.0;
            $image = $item['image'] ?? '';

            Item::firstOrCreate([
                'uuid' => $uuid,
                'name' => $name,
                'url' => $url,
                'description' => $description,
                'price' => $price,
                'image' => $image,
                'category_id' => $category->id,
            ]);
        }
    }
}
