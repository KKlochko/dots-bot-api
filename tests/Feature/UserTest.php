<?php

namespace Tests\Feature;

use App\Http\Controllers\API\v2\UserController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Request;

use App\Models\User;

class UserTest extends TestCase
{
    protected $username = 'Oleg';
    protected $matrixUsername = '@oleg:oleg.com';
    protected $phone = '380671231212';

    protected $notExistingUser = [
        'username' => 'Kostia',
        'matrix_username' => '@kostia:kostia.com',
    ];

    public function test_register_new_user(): void
    {
        $response = $this->post('/api/v2/register', [
            'username' => $this->username,
            'matrix_username' => $this->matrixUsername,
            'phone' => $this->phone,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'A user with the username registered successfully.'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $this->username
        ]);
    }

    public function test_register_existing_user(): void
    {
        $response = $this->post('/api/v2/register', [
            'username' => $this->username,
            'matrix_username' => $this->matrixUsername,
            'phone' => $this->phone,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'A user with the username already exists!!!'
        ]);
    }

    public function test_login_not_existing_user(): void
    {
        $response = $this->post('/api/v2/login', $this->notExistingUser);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'A user with the username does not exist!!!'
        ]);
    }

    public function test_login_existing_user(): void
    {
        $response = $this->post('/api/v2/login', [
            'username' => $this->username,
            'matrix_username' => $this->matrixUsername,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'Login was successful.'
        ]);
    }

    public function test_removing_user(): void
    {
        $user = User::where('username', $this->username)->first();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'username' => $this->username
        ]);
    }
}
