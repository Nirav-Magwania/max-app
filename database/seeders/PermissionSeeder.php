<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::updateOrCreate(['name' => 'create-user']);
        Permission::updateOrCreate(['name' => 'delete-user']);
        Permission::updateOrCreate(['name' => 'update-user']);
        Permission::updateOrCreate(['name' => 'view-user']);
        Permission::updateOrCreate(['name' => 'edit-user']);
        Permission::updateOrCreate(['name' => 'publish-user']);
        Permission::updateOrCreate(['name' => 'modify-user']);
        Permission::updateOrCreate(['name' => 'suspend-user']);
    }
}
