<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'url',
    ];

    public static function validate_with_name(string $name)
    {
        $name = $name ?? '';

        if($name == '')
            return [
                'error' => 'The city name is empty, please, write the name!!!'
            ];

        $city = City::where('name', $name)->first();

        if(!$city)
            return [
                'error' => 'A city with the name does not exist!!!'
            ];

        return [
            'ok' => 'A city with the name is valid.'
        ];
    }
}
