<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'matrix_username',
        'phone',
    ];

    public static function validate_with_matrix_username(string $matrix_username)
    {
        $matrix_username = $matrix_username ?? '';

        if($matrix_username == '')
            return [
                'error' => 'The username is empty, please, write username!!!'
            ];

        $user = User::where('matrix_username', $matrix_username)->first();

        if(!$user)
            return [
                'error' => 'A user with the username does not exist!!!'
            ];

        return [
            'ok' => 'A user with the username is valid.'
        ];
    }
}
