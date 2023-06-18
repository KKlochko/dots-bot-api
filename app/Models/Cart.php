<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\City;

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'carts_items', 'cart_id', 'item_id');
    }

    public function isEmpty() {
        return $this->items()->isEmpty();
    }

    public function setCity(City $city) {
        if($this->city_id == $city->id)
            return;

        $this->city_id = $city->id;

        if(!$this->isEmpty())
            $this->dropItems();

        $this->save();
    }

    public function dropItems() {
        $this->items()->detach();
    }
}

