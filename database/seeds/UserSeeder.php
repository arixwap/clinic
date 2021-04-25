<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create superadmin account
        Role::where('slug', 'superadmin')->first()->users()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@clinic.test',
            'password' => Hash::make('12345678'),
        ]);

        // Create standar user account
        Role::where('slug', 'user')->first()->users()->create([
            'name' => 'User',
            'email' => 'user@clinic.test',
            'password' => Hash::make('12345678'),
        ]);
    }
}
