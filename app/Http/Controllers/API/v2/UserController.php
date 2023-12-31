<?php

namespace App\Http\Controllers\API\v2;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $username = $request->input('username') ?? '';
        $matrixUsername = $request->input('matrixUsername') ?? '';
        $phone = $request->input('phone') ?? '';

        if($username == '') {
            return response()->json([
                'error' => 'The username is empty, please, write username!!!'
            ]);
        }

        $user = User::firstOrCreate(
            ['username' => $username],
            // if username is free then the new user will be created
            // with addition arguments:
            [
                'matrix_username' => $matrixUsername,
                'phone' => $phone
            ]
        );

        if(!$user->wasRecentlyCreated) {
            return response()->json([
                'error' => 'A user with the username already exists!!!'
            ]);
        }

        return response()->json([
            'ok' => 'A user with the username registered successfully.'
        ]);
    }

    public function login(Request $request)
    {
        $username = $request->input('username') ?? '';
        $matrixUsername = $request->input('matrixUsername') ?? '';

        if($username == '') {
            return response()->json([
                'error' => 'The username is empty, please, write username!!!'
            ]);
        }

        $user = User::where('username', $username)->first();

        if(!$user) {
            return response()->json([
                'error' => 'A user with the username does not exist!!!'
            ]);
        }

        // Update matrix user if needed
        // TODO add verification check
        if($user->matrix_username != $matrixUsername) {
            $user->matrix_username = $matrixUsername;
            $user->save();
        }

        return response()->json([
            'ok' => 'Login was successful.'
        ]);
    }
}
