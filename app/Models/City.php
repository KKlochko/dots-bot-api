<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'url',
    ];

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'cities_companies', 'city_id', 'company_id');
    }

    public function getCompanyIds(): array
    {
        return $this->companies()->pluck('company_id')->toArray();
    }

    public function getCompanies()
    {
        return $this->companies;
    }

    public function addCompanyId(int $company_id)
    {
        $this->addCompanyIds([$company_id]);
    }

    public function addCompanyIds(array $company_ids)
    {
        $companyIDs = array_merge($this->getCompanyIds(), $company_ids);
        $this->companies()->sync($companyIDs);
    }

    public function removeCompanyId(int $company_id)
    {
        $this->companies()->detach($company_id);
    }

    public function removeCompanyIds(array $company_ids)
    {
        $this->companies()->detach($company_ids);
    }

    public static function validateWithName(string $name)
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
