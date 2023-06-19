<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use App\Models\City;
use App\Models\Company;
use App\Models\Item;
use App\Models\Cart;

class CartTest extends TestCase
{
    protected $test_user_username = 'Test';
    protected $test_city_name = 'testCity';
    protected $test_city_name2 = 'testCity2';
    protected $test_company_name = 'testCompany';
    protected $test_company_name2 = 'testCompany2';

    protected $test_item_name = 'Pizza Polo';
    protected $test_item_name2 = 'Pizza Cezar';

    protected $test_user;
    protected $test_city;
    protected $test_company;
    protected $test_item;

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

    public function test_select_another_city(): void
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

    public function test_select_company_first_time(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_company = Company::where('name', $this->test_company_name)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_company);

        $response = $this->post('/api/v2/select-company', [
            'matrix_username' => $this->test_user->matrix_username,
            'company_name' => $this->test_company->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'Company selected successfully',
            'name' => $this->test_company->name,
            'uuid' => $this->test_company->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'company_id' => $this->test_company->id,
            'user_id' => $this->test_user->id,
            'status' => 'CART',
        ]);
    }

    public function test_select_another_company(): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_company = Company::where('name', $this->test_company_name2)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_company);

        $response = $this->post('/api/v2/select-company', [
            'matrix_username' => $this->test_user->matrix_username,
            'company_name' => $this->test_company->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'Company changed successfully',
            'name' => $this->test_company->name,
            'uuid' => $this->test_company->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'company_id' => $this->test_company->id,
            'user_id' => $this->test_user->id,
            'status' => 'CART',
        ]);
    }

    /* Test cart and items */

    public function testAddFirstCartItem(): int
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_item = Item::where('name', $this->test_item_name)->first();
        $count = 2;

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_item);

        $response = $this->post('/api/v2/add-item', [
            'matrixUsername' => $this->test_user->matrix_username,
            'itemName' => $this->test_item->name,
            'itemCount' => $count,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'The item added successfully',
            'name' => $this->test_item->name,
            'uuid' => $this->test_item->uuid,
            'count' => $count,
        ]);

        return $count;
    }

    /**
      * @depends testAddFirstCartItem
      */
    public function testExistingNewCartItem($count): int
    {
        $this->test_item = Item::where('name', $this->test_item_name)->first();

        $this->assertNotNull($this->test_item);

        $this->assertDatabaseHas('items', [
            'uuid' => $this->test_item->uuid,
            'name' => $this->test_item->name,
            'count' => $count,
        ]);

        return $count;
    }

    /**
      * @depends testExistingNewCartItem
      */
    public function testExistingCartItemRelationship($count): int
    {
        $this->test_item = Item::where('name', $this->test_item_name)->first();

        $this->assertNotNull($this->test_item);

        $cart_item = Item::where('uuid', $this->test_item->uuid)
                   ->where('count', $count)
                   ->first();

        $this->assertDatabaseHas('carts_items', [
            'item_id' => $cart_item->id,
        ]);

        return $count;
    }

    /**
      * @depends testExistingCartItemRelationship
      */
    public function testAddItemAgain($count): int
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_item = Item::where('name', $this->test_item_name)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_item);

        $response = $this->post('/api/v2/add-item', [
            'matrixUsername' => $this->test_user->matrix_username,
            'itemName' => $this->test_item->name,
            // the count as before
            'itemCount' => $count,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'The item count is changed successfully',
            'name' => $this->test_item->name,
            'uuid' => $this->test_item->uuid,
            // the count as before, therefore it must be doubled.
            'count' => $count * 2,
        ]);

        return $count;
    }

    /**
      * @depends testAddItemAgain
      */
    public function testDoubledItemCount($count): void
    {
        $this->test_user = User::where('username', $this->test_user_username)->first();
        $this->test_item = Item::where('name', $this->test_item_name)->first();

        $this->assertNotNull($this->test_user);
        $this->assertNotNull($this->test_item);

        $this->assertDatabaseHas('items', [
            'uuid' => $this->test_item->uuid,
            'name' => $this->test_item->name,
            'count' => $count * 2,
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
