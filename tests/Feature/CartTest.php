<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\City;
use App\Models\Cart;

class CartTest extends TestCase
{
    protected $test_user_username = 'Test';
    protected $test_city_name = 'testCity';
    protected $test_city_name2 = 'testCity2';

    protected $test_user;
    protected $test_city;

    public function test_get_data(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_city = City::where('name', $this->test_city_name)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_city);
    }

    public function test_select_city_first_time(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_city = City::where('name', $this->test_city_name)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_city);

        $response = $this->post('/api/v2/select-city', [
            'matrix_username' => $this->test_user->matrix_username,
            'city_name' => $this->test_city->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'City selected successfully',
            'name' => $this->test_city->name,
            'uuid' => $this->test_city->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'city_id' => $this->test_city->id,
            'user_id' => $this->test_user->id,
            'status' => 'CART',
        ]);
    }

    public function test_select_another_city_time(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_city = City::where('name', $this->test_city_name2)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_city);

        $response = $this->post('/api/v2/select-city', [
            'matrix_username' => $this->test_user->matrix_username,
            'city_name' => $this->test_city->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'City changed successfully',
            'name' => $this->test_city->name,
            'uuid' => $this->test_city->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'city_id' => $this->test_city->id,
            'user_id' => $this->test_user->id,
            'status' => 'CART',
        ]);
    }

    public function test_removing_cart(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_city = City::where('name', $this->test_city_name2)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_city);

        $cart = Cart::where('status', 'CART')
              ->where('user_id', $this->test_user->id)
              ->where('city_id', $this->test_city->id)
              ->first();
        $cart->delete();

        $this->assertNotNull($cart);

        $this->assertDatabaseMissing('carts', [
            'status' => 'CART',
            'user_id' => $this->test_user->id,
            'city_id'=> $this->test_city->id
        ]);
    }

    public function test_select_city_with_no_city(): void
    {
        $this->test_city = City::where('name', $this->test_city_name2)->first();

        $this->assertNotNull($this->test_city);

        $response = $this->post('/api/v2/select-city', [
            'matrix_username' => '',
            'city_name' => $this->test_city->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'The username is empty, please, write username!!!'
        ]);
    }

    public function test_select_city_with_no_user(): void
    {
        $this->test_city = City::where('name', $this->test_city_name2)->first();

        $this->assertNotNull($this->test_city);

        $response = $this->post('/api/v2/select-city', [
            'matrix_username' => '',
            'city_name' => $this->test_city->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'The username is empty, please, write username!!!'
        ]);
    }
}
