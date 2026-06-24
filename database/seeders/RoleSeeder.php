<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'rcc_staff', 'display_name' => 'RCC Staff'],
            ['name' => 'treasurer', 'display_name' => 'Treasurer'],
            ['name' => 'mayor', 'display_name' => 'Mayor'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }
    }
}
