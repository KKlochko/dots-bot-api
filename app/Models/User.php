<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Validation\ValidationByNameInterface;

class User extends Authenticatable implements ValidationByNameInterface
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




    public static function isExistByName(string $name): bool
    {
        $count = User::where('matrix_username', $name)->count();

        return $count != 0;
    }

    public static function isNameValid(string $name): bool
    {
        return $name != '';
    }
}
