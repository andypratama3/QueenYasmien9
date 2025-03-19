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

        // Ambil role 'superadmin' dari database
        $superadmin = Role::where('name', 'superadmin')->first();

        // Pastikan role ditemukan sebelum diberikan ke user
        if ($superadmin) {
            $user->assignRole('superadmin');
        } else {
            $this->command->error('Role "superadmin" tidak ditemukan.');
        }
    }
}
