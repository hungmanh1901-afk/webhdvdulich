<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@hdvdulich.test'],
            [
                'full_name' => 'Quản trị viên',
                'password' => Hash::make('password'),
                'phone' => '0900000000',
                'address' => 'Hà Nội',
                'role' => User::ROLE_ADMIN,
            ]
        );
    }
}
