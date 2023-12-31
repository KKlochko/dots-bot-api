<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v2\CityResource;
use App\Http\Resources\API\v2\CityCollection;

// Dots API
use App\DotsAPI\Fetcher\v2\ApiFetcher;
use App\DotsAPI\API\v2\CityAPI;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Update list of cities
        $fetcher = new ApiFetcher();
        $cityAPI = new CityAPI($fetcher);

        $citiesMap = $cityAPI->getMap();
        $cityAPI->saveMap($citiesMap);

        return new CityCollection(City::all());
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
    public function store(StoreCityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return new CityResource($city);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCityRequest $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        //
    }
}
