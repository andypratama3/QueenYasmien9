<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role; // Gunakan model Role Anda sendiri
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin@gmail.com'),
        ]);

        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Berikan role ke user baru
        $user->assignRole($role);
    }
}
