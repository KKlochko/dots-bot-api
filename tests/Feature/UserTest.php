<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserTest extends TestCase
{
    public function test_register_new_user(): void
    {
        $username = 'Oleg';
        $matrix_username = 'Oleg@oleg.com';
        $phone = '380671231212';

        $response = $this->post('/api/v2/register', [
            'username' => $username,
            'matrix_username' => $matrix_username,
            'phone' => $phone,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'A user with the username registered successfully.'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $username
        ]);

        $user = User::where('username', $username)->first();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'username' => $username
        ]);
    }

    public function test_register_existing_user(): void
    {
        $username = 'Oleg';
        $matrix_username = 'Oleg@oleg.com';
        $phone = '380671231212';

        $response = $this->post('/api/v2/register', [
            'username' => $username,
            'matrix_username' => $matrix_username,
            'phone' => $phone,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'ok' => 'A user with the username registered successfully.'
        ]);

        $this->assertDatabaseHas('users', [
            'username' => $username
        ]);

        // trying create again

        $response = $this->post('/api/v2/register', [
            'username' => $username,
            'matrix_username' => $matrix_username,
            'phone' => $phone,
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'error' => 'A user with the username already exists!!!'
        ]);

        // removing new user

        $user = User::where('username', $username)->first();
        $user->delete();

        $this->assertDatabaseMissing('users', [
            'username' => $username
        ]);
    }
}
