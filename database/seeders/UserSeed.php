<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@admin.com')->first()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456'),
            ]);
        }
        if (!User::where('email', 'user@user.com')->first()) {
            User::create([
                'name' => 'User',
                'email' => 'user@user.com',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
