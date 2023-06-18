<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\API\v2\CartResource;
use App\Models\Cart;
use App\Models\User;
use App\Models\City;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v2\UserController;
use Illuminate\Auth\Events\Validated;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function selectCity(Request $request) {
        $matrix_username = $request->input('matrix_username') ?? '';
        $city_name = $request->input('city_name') ?? '';

        // check for not valid user
        $validation = User::validate_with_matrix_username($matrix_username);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // check for not valid city
        $validation = City::validate_with_name($city_name);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // Get objects
        $user = User::where('matrix_username', $matrix_username)->first();
        $city = City::where('name', $city_name)->first();

        $cart = Cart::firstOrCreate(
            [
                'user_id' => $user->id,
                'status' => 'CART'
            ],
            [
                'city_id' => $city->id,
            ]
        );

        if($cart->city_id != $city->id) {
            $cart->setCity($city);

            return response()->json([
                'ok' => 'City changed successfully',
                'name' => $city->name,
                'uuid' => $city->uuid,
            ]);
        }

        return response()->json([
            'ok' => 'City selected successfully',
            'name' => $city->name,
            'uuid' => $city->uuid,
        ]);
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
    public function store(StoreCartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        return new CartResource($cart);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
