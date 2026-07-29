<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'role_name' => 'Admin',
                'description' => 'System Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Registrar Staff',
                'description' => 'Registrar Office Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Professor',
                'description' => 'Faculty Member',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_name' => 'Student',
                'description' => 'Enrolled Student',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
