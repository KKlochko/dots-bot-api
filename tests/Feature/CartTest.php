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
    protected $testUserUsername = 'Test';
    protected $testCityName = 'testCity';
    protected $testCityName2 = 'testCity2';
    protected $testCompanyName = 'testCompany';
    protected $testCompanyName2 = 'testCompany2';

    protected $testItemName = 'Pizza Polo';
    protected $testItemName2 = 'Pizza Cezar';

    protected $testUser;
    protected $testCity;
    protected $testCompany;
    protected $testItem;

    public function test_get_data(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCity = City::where('name', $this->testCityName)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCity);
    }

    public function test_select_city_first_time(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCity = City::where('name', $this->testCityName)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCity);

        $response = $this->post('/api/v2/select-city', [
            'matrixUsername' => $this->testUser->matrix_username,
            'cityName' => $this->testCity->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'City selected successfully',
            'name' => $this->testCity->name,
            'uuid' => $this->testCity->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'city_id' => $this->testCity->id,
            'user_id' => $this->testUser->id,
            'status' => 'CART',
        ]);
    }

    public function test_select_another_city(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCity = City::where('name', $this->testCityName2)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCity);

        $response = $this->post('/api/v2/select-city', [
            'matrixUsername' => $this->testUser->matrix_username,
            'cityName' => $this->testCity->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'City changed successfully',
            'name' => $this->testCity->name,
            'uuid' => $this->testCity->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'city_id' => $this->testCity->id,
            'user_id' => $this->testUser->id,
            'status' => 'CART',
        ]);
    }

    public function test_select_company_first_time(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCompany = Company::where('name', $this->testCompanyName)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCompany);

        $response = $this->post('/api/v2/select-company', [
            'matrixUsername' => $this->testUser->matrix_username,
            'companyName' => $this->testCompany->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'Company selected successfully',
            'name' => $this->testCompany->name,
            'uuid' => $this->testCompany->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'company_id' => $this->testCompany->id,
            'user_id' => $this->testUser->id,
            'status' => 'CART',
        ]);
    }

    public function test_select_another_company(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCompany = Company::where('name', $this->testCompanyName2)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCompany);

        $response = $this->post('/api/v2/select-company', [
            'matrixUsername' => $this->testUser->matrix_username,
            'companyName' => $this->testCompany->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'Company changed successfully',
            'name' => $this->testCompany->name,
            'uuid' => $this->testCompany->uuid,
        ]);

        $this->assertDatabaseHas('carts', [
            'company_id' => $this->testCompany->id,
            'user_id' => $this->testUser->id,
            'status' => 'CART',
        ]);
    }

    /* Test cart and items */

    public function testAddFirstCartItem(): int
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testItem = Item::where('name', $this->testItemName)->first();
        $count = 2;

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testItem);

        $response = $this->post('/api/v2/add-item', [
            'matrixUsername' => $this->testUser->matrix_username,
            'itemName' => $this->testItem->name,
            'itemCount' => $count,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'The item added successfully',
            'name' => $this->testItem->name,
            'uuid' => $this->testItem->uuid,
            'count' => $count,
        ]);

        return $count;
    }

    /**
      * @depends testAddFirstCartItem
      */
    public function testExistingNewCartItem($count): int
    {
        $this->testItem = Item::where('name', $this->testItemName)->first();

        $this->assertNotNull($this->testItem);

        $this->assertDatabaseHas('items', [
            'uuid' => $this->testItem->uuid,
            'name' => $this->testItem->name,
            'count' => $count,
        ]);

        return $count;
    }

    /**
      * @depends testExistingNewCartItem
      */
    public function testExistingCartItemRelationship($count): int
    {
        $this->testItem = Item::where('name', $this->testItemName)->first();

        $this->assertNotNull($this->testItem);

        $cart_item = Item::where('uuid', $this->testItem->uuid)
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
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testItem = Item::where('name', $this->testItemName)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testItem);

        $response = $this->post('/api/v2/add-item', [
            'matrixUsername' => $this->testUser->matrix_username,
            'itemName' => $this->testItem->name,
            // the count as before
            'itemCount' => $count,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'The item count is changed successfully',
            'name' => $this->testItem->name,
            'uuid' => $this->testItem->uuid,
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
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testItem = Item::where('name', $this->testItemName)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testItem);

        $this->assertDatabaseHas('items', [
            'uuid' => $this->testItem->uuid,
            'name' => $this->testItem->name,
            'count' => $count * 2,
        ]);
    }

    // TODO item from another company -> error
    public function test_removing_cart(): void
    {
        $this->testUser = User::where('username', $this->testUserUsername)->first();
        $this->testCity = City::where('name', $this->testCityName2)->first();

        $this->assertNotNull($this->testUser);
        $this->assertNotNull($this->testCity);

        $cart = Cart::where('status', 'CART')
              ->where('user_id', $this->testUser->id)
              ->where('city_id', $this->testCity->id)
              ->first();
        $cart->delete();

        $this->assertNotNull($cart);

        $this->assertDatabaseMissing('carts', [
            'status' => 'CART',
            'user_id' => $this->testUser->id,
            'city_id'=> $this->testCity->id
        ]);
    }

    public function test_select_city_with_no_city(): void
    {
        $this->testCity = City::where('name', $this->testCityName2)->first();

        $this->assertNotNull($this->testCity);

        $response = $this->post('/api/v2/select-city', [
            'matrixUsername' => '',
            'cityName' => $this->testCity->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'The username is invalid, please, check that you are registered or signed in!!!'
        ]);
    }

    public function test_select_city_with_no_user(): void
    {
        $this->testCity = City::where('name', $this->testCityName2)->first();

        $this->assertNotNull($this->testCity);

        $response = $this->post('/api/v2/select-city', [
            'matrixUsername' => '',
            'cityName' => $this->testCity->name,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'The username is invalid, please, check that you are registered or signed in!!!'
        ]);
    }
}
