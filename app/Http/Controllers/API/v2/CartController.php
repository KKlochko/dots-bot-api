<?php

namespace App\Http\Controllers\API\v2;

use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Http\Resources\API\v2\CartResource;
use App\Models\Cart;
use App\Models\User;
use App\Models\City;
use App\Models\Company;
use App\Models\Item;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v2\UserController;
use Illuminate\Auth\Events\Validated;

use App\DotsAPI\Fetcher\v2\ApiFetcher;
use App\DotsAPI\Fetcher\v2\AuthApiFetcher;
use App\DotsAPI\Fetcher\v2\AuthApiSender;
use App\Http\Resources\API\v2\CartItemCollection;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $user = null;

        if(!$matrixUsername)
            return response()->json([
                'error' => ''
            ]);

        $user = User::firstOrCreate([
            'matrix_username' => $matrixUsername
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'CART'
        ]);

        return new CartItemCollection($cart->items);
    }

    public function order(Request $request)
    {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $user = null;

        if(!$matrixUsername)
            return response()->json([
                'error' => ''
            ]);

        $user = User::firstOrCreate([
            'matrix_username' => $matrixUsername
        ]);

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'CART'
        ]);

        $city = $cart->getCity();
        $company = $cart->getCompany();

        $fetcher = new ApiFetcher();
        $authSender = new AuthApiSender();
        $authFetcher = new AuthApiFetcher();

        $companyInfoEndpoint = '/api/v2/companies/' . $company->uuid;

        // get first data for testing
        $companyData = $fetcher->get($companyInfoEndpoint, '');
        $address = $companyData['addresses'];
        $addressUUID = $address[0]['id'];

        $orderEndpoint = '/api/v2/orders';
        $order = [
            "orderFields" => [
                "cityId" => $city->uuid,
                "companyId" => $company->uuid,
                "companyAddressId" => $addressUUID,
                "userName" => $user->username,
                "userPhone" => $user->phone,
                "deliveryType" => 2, // no delivery, pickup
                "paymentType" => 1, // cash
                "deliveryTime" => 0, // test, as fast as posible
                "cartItems" => $cart->getItemJSON()
            ]
        ];

        $orderID = $authSender->get($orderEndpoint, $order);

        // wait for creating
        sleep(3);

        $orderEndpoint = '/api/v2/orders/' . $orderID;
        $orderData = $authFetcher->get($orderEndpoint, '');

        $cart->status = 'DONE';
        $cart->save();

        return $orderData;
    }

    public function selectCity(Request $request) {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $cityName = $request->input('cityName') ?? '';

        // check for not valid user
        $validation = User::validate_with_matrix_username($matrixUsername);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // check for not valid city
        $validation = City::validate_with_name($cityName);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // Get objects
        $user = User::where('matrix_username', $matrixUsername)->first();
        $city = City::where('name', $cityName)->first();

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

    public function selectCompany(Request $request) {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $companyName = $request->input('companyName') ?? '';

        // check for not valid user
        $validation = User::validate_with_matrix_username($matrixUsername);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // check for not valid company
        $validation = Company::validate_with_name($companyName);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // Get objects
        $user = User::where('matrix_username', $matrixUsername)->first();
        $company = Company::where('name', $companyName)->first();

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'CART'
        ]);

        if($cart->company_id != $company->id && $cart->company_id != null) {
            $cart->setCompany($company);

            return response()->json([
                'ok' => 'Company changed successfully',
                'name' => $company->name,
                'uuid' => $company->uuid,
            ]);
        }

        $cart->setCompany($company);

        return response()->json([
            'ok' => 'Company selected successfully',
            'name' => $company->name,
            'uuid' => $company->uuid,
        ]);
    }

    public function addItem(Request $request) {
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $itemName = $request->input('itemName') ?? '';
        $itemCount = $request->input('itemCount') ?? '';

        // check for not valid user
        $validation = User::validate_with_matrix_username($matrixUsername);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        // check for not valid item
        $validation = Item::validate_with_name($itemName);
        if(array_key_exists('error', $validation))
            return response()->json($validation);

        if($itemCount == 0)
            return response()->json([
                'error' => 'The item count is zero!!! Please, choose the count!!!',
            ]);

        // Get objects
        $user = User::where('matrix_username', $matrixUsername)->first();

        // Select template item
        $item = Item::where('name', $itemName)
              ->where('count', 0)
              ->first();

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'CART'
        ]);

        if($cart->isItemIn($item)) {
            $cartItem = $cart->getItem($itemName);
            $cartItem->setCount($cartItem->getCount() + $itemCount);

            return response()->json([
                'ok' => 'The item count is changed successfully',
                'name' => $cartItem->name,
                'uuid' => $cartItem->uuid,
                'count' => $cartItem->count,
            ]);
        }

        // Clone template value:
        $cartItem = $item->clone($itemCount);
        $cart->addItemId($cartItem->id);

        return response()->json([
            'ok' => 'The item added successfully',
            'name' => $item->name,
            'uuid' => $item->uuid,
            'count' => $cartItem->count,
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
