<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $managerRole = Role::create(['name' => 'manager']);
        $driverRole = Role::create(['name' => 'driver']);

        // Create users
        $erni = User::create([
            'name' => 'Erni',
            'email' => 'erni@example.com',
            'password' => Hash::make('password'),
        ]);
        $erni->assignRole($adminRole);

        $budi = User::create([
            'name' => 'Budi',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
        ]);
        $budi->assignRole($driverRole);

        $john = User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);
        $john->assignRole($managerRole);
    }
}
