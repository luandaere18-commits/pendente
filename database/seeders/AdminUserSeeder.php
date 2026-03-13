<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@site.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('senha123'),
                'is_admin' => true,
            ]
        );
    }
}
