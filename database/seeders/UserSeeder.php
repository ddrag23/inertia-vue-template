<?php

namespace Database\Seeders;

use App\Constant\RoleConstant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'superadmin',
                'password' => Hash::make('password'),
                'email' => 'superadmin@mail.com',
                'user_role' => RoleConstant::SUPERADMIN,
            ],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'email' => 'admin@mail.com',
                'user_role' => RoleConstant::ADMIN
            ],
            [
                'name' => 'siswa',
                'password' => Hash::make('password'),
                'email' => 'siswa@mail.com',
                'user_role' => RoleConstant::STUDENT
            ],
            [
                'name' => 'wali_murid',
                'password' => Hash::make('password'),
                'email' => 'wali_murid@mail.com',
                'user_role' => RoleConstant::WALI_MURID
            ]
        ];
        collect($users)->each(function ($item) {
            $userData = array(
                'name' => $item['name'],
                'email' => $item['email'],
                'password' => $item['password'],
            );
            User::create($userData)
                ->assignRole($item['user_role']);
        });
    }
}
