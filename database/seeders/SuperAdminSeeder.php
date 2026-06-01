<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@diagnostic.com',
            'password' => Hash::make('password'),
            'phone' => '01700000000',
            'designation' => 'System Administrator',
            'is_active' => true,
        ]);

        $user->assignRole('Super Admin');
    }
}