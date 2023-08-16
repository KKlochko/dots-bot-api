<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'image',
        'description',
    ];

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'cities_companies', 'company_id', 'city_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public static function isExist(int $company_id): bool
    {
        $count = Company::where('id', $company_id)->count();

        return $count != 0;
    }

    public static function validate_with_name(string $name)
    {
        $name = $name ?? '';

        if($name == '')
            return [
                'error' => 'The company name is empty, please, write the name!!!'
            ];

        $company = company::where('name', $name)->first();

        if(!$company)
            return [
                'error' => 'A company with the name does not exist!!!'
            ];

        return [
            'ok' => 'A company with the name is valid.'
        ];
    }
}
