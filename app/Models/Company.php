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

    public static function isExist(int $id): bool
    {
        $count = Company::where('id', $id)->count();

        return $count != 0;
    }
}
