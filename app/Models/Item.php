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
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'carts_items', 'item_id', 'cart_id');
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

