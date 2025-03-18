<?php

namespace App\Actions\Fortify;

use App\Models\Role;
// use Spatie\Permission\Models\Role;
use App\Models\User;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'password' => array_merge($this->passwordRules(), ['max:100']),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted'] : [], 
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // Pastikan role 'user' tersedia, jika tidak, buat
        $role = Role::firstOrCreate(['name' => 'user']);

        // Berikan role ke user baru
        $user->assignRole($role);

        return $user;
    }
}
