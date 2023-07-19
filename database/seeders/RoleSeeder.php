<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'superadmin'],
            ['name' => 'admin'],
            ['name' => 'siswa'],
            ['name' => 'wali_murid'],
        ];
        collect($roles)->each(fn ($item) => Role::create($item));
    }
}
