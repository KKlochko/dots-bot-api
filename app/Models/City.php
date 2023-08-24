<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Models\Validation\ValidationByNameInterface;
use App\Models\Company;

class City extends Model implements ValidationByNameInterface
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

    public function userAddresses(): HasMany
    {
        return $this->hasMany(UserAddress::class);
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
        if(Company::isExist($company_id))
            $this->addCompanyIds([$company_id]);
    }

    public function addCompanyIds(array $company_ids)
    {
        $existingCompanies = array_filter($company_ids, ['App\Models\Company', 'isExist']);

        $companyIDs = array_merge($this->getCompanyIds(), $existingCompanies);

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

    public static function isExistByName(string $name): bool
    {
        $count = City::where('name', $name)->count();

        return $count != 0;
    }

    public static function isNameValid(string $name): bool
    {
        return $name != '';
    }
}
