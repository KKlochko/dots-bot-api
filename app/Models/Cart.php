<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\City;
use App\Models\Company;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', // CART | DONE
        'user_id',
        'city_id',
        'company_id'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function getCity(): City
    {
        return City::where('city_id', $this->city_id)->first();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getCompany(): Company
    {
        return Company::where('company_id', $this->company_id)->first();
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'carts_items', 'cart_id', 'item_id');
    }

    public function getItemIds(): array
    {
        return $this->items()->pluck('item_id')->toArray();
    }

    public function isEmpty()
    {
        return count($this->getItemIds());
    }

    public function dropItems() {
        $this->items()->detach();
    }

    public function setCity(City $city)
    {
        if($this->city_id == $city->id)
            return;

        $this->city_id = $city->id;

        if(!$this->isEmpty())
            $this->dropItems();

        $this->save();
    }

    public function setCompany(Company $company)
    {
        if($this->company_id == $company->id)
            return;

        $this->company_id = $company->id;

        if(!$this->isEmpty())
            $this->dropItems();

        $this->save();
    }

    public function addItemId(int $item)
    {
        $this->items()->sync($item);
    }

    public function addItemIds(array $items)
    {
        $this->items()->sync($items);
    }

    public function removeItemId(int $item)
    {
        $this->items()->sync($item);
    }

    public function removeItemIds(array $items)
    {
        $this->items()->sync($items);
    }
}

