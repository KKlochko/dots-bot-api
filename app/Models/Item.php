<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'url',
        'description',
        'price',
        'image',
        'category_id',
        // if an item in a cart, then the count is a nonzero value.
        'count',
    ];

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count = 1)
    {
        $this->count = $count;
        $this->save();
    }

    public function clone($count = 1): Item
    {
        $copyItem = $this->replicate();

        $copyItem->setCount($count);

        return $copyItem;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'carts_items', 'item_id', 'cart_id');
    }

    public function getCategory(): Category
    {
        $category = Category::where('id', $this->category_id)->first();

        return $category;
    }

    public function getCompany()
    {
        $category = $this->getCategory();

        if($category == null)
            return null;

        $company = Company::where('id', $category->company_id)->first();

        return $company;
    }

    public function isBelong(Company $company): bool
    {
        $category = $this->getCategory();

        if($category == null)
            return false;

        $its_company = $this->getCompany();

        if($its_company == null or $company == null)
            return false;

        return $its_company->id == $company->id;
    }

    public static function validate_with_name(string $name)
    {
        $name = $name ?? '';

        if($name == '')
            return [
                'error' => 'The item name is empty, please, write the name!!!'
            ];

        $item = Item::where('name', $name)->first();

        if(!$item)
            return [
                'error' => 'A item with the name does not exist!!!'
            ];

        return [
            'ok' => 'A item with the name is valid.'
        ];
    }
}

