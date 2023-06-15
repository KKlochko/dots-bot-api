<?php

namespace App\Http\Resources\API\v2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $city_name = $this->city->name;
        $company_name = $this->company->name;
        $items = $this->items;

        return [
            'id' => $this->id,
            'cityName' => $city_name,
            'companyName' => $company_name,
            'item' => new ItemCollection($items),
        ];
    }
}
