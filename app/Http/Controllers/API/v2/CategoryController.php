<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\v2\CategoryResource;
use App\Http\Resources\API\v2\CategoryCollection;

// Dots API
use App\DotsAPI\Fetcher\v2\ApiFetcher;
use App\DotsAPI\API\v2\CategoryItemAPI;

use App\Models\User;
use App\Models\Cart;
use App\Models\Company;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $companyUUID = $request->input('uuid') ?? '';
        $user = null;
        $cart = null;
        $company = null;

        if($companyUUID != ''){
            $company = Company::where('uuid', $companyUUID)->first();
        }

        if($matrixUsername) {
            $user = User::firstOrCreate([
                'matrix_username' => $matrixUsername
            ]);

            $cart = Cart::firstOrCreate([
                'user_id' => $user->id,
                'status' => 'CART'
            ]);

            $company = $cart->getCompany();
            $companyUUID = $company->uuid;
        }

        if(!$company)
            return response()->json([
                'error' => '404 company'
            ]);

        // Update list of companies
        $fetcher = new ApiFetcher();
        $categoryItemAPI = new CategoryItemAPI($fetcher);

        $categoriesItemsMap = $categoryItemAPI->getMap($companyUUID);
        $categoryItemAPI->saveMap($categoriesItemsMap, $company);

        // Companies Categories
        $categories = Category::where('company_id', $company->id)->get();

        return new CategoryCollection($categories);
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
    public function store(StoreCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
