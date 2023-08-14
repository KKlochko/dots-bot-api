<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Http\Request;

use App\Models\User;

class UserValidationTest extends TestCase
{
    public function testEmptyUsernameWithMatrixUsername(): void
    {
        $json = User::validateWithMatrixUsername('');

        $this->assertEquals($json['error'], 'The username is empty, please, write username!!!');
    }

    public function testValidUserWithMatrixUsername(): void
    {
        $matrixUsername = '@test:test.com';

        $json = User::validateWithMatrixUsername($matrixUsername);

        $this->assertEquals($json['ok'], 'A user with the username is valid.');
    }

    public function testNotExistingUserWithMatrixUsername(): void
    {
        $matrixUsername = '@kostia:test.com';

        $json = User::validateWithMatrixUsername($matrixUsername);

        $this->assertEquals($json['error'], 'A user with the username does not exist!!!');
    }
}
