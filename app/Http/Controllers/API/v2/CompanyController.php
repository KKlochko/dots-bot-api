<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v2\CompanyResource;
use App\Http\Resources\API\v2\CompanyCollection;

// Dots API
use App\DotsAPI\Fetcher\v2\ApiFetcher;
use App\DotsAPI\API\v2\CompanyAPI;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $city_uuid = $request->input('uuid');

        // Update list of companies
        $fetcher = new ApiFetcher();
        $companyAPI = new CompanyAPI($fetcher);

        $companyMap = $companyAPI->getMap($city_uuid);
        $companyAPI->saveMap($companyMap);

        return new CompanyCollection(Company::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        //
    }
}
