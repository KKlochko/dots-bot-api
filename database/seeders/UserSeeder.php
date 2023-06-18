<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    protected $test_user = [
        'username' => 'Test',
        'matrix_username' => '@test:test.com',
        'phone' => '380661234567'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create($this->test_user);
    }
}
