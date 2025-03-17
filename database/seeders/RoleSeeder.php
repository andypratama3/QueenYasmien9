<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'superadmin',
            'admin',
            'reseller',
            'owner',
            'user'
        ];

        $permissions = [
            'dashboard',
        ];

        //


        foreach ($roles as $role) {
            Role::create([
                'name' => $role
            ]);
        }

        foreach ($permissions as $permission) {
            Permission::create([
                'id' => Str::uuid(),
                'name' => $permission,
                'guard_name' => 'web'
            ]);
            $role = Role::where('name', 'superadmin')->first();
            $role->givePermissionTo($permission);
        }
    }
}
