<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'Main Branch',
            'slug' => 'main-branch',
            'code' => 'BR001',
            'address' => '123, Main Street, Dhaka',
            'phone' => '01700000001',
            'email' => 'main@diagnostic.com',
            'is_active' => true,
            'is_main_branch' => true,
        ]);
    }
}