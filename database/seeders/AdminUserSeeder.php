<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert Admin for Department 1
        DB::table('users')->insert([
            'name' => 'Admin CST',
            'email' => 'admin_cst@gmail.com',
            'roleName' => 'Admin',
            'roleId' => 3, // Assuming 1 is the Admin role ID
            'userCreatedBy' => null, // Can be set if needed
            'department' => 1,
            'departmentName' => 'Computer Science',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'), // You can set a different password here
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert Admin for Department 2
        DB::table('users')->insert([
            'name' => 'Admin Business Department',
            'email' => 'admin_e@gmail.com',
            'roleName' => 'Admin',
            'roleId' => 3, // Assuming 1 is the Admin role ID
            'userCreatedBy' => null, // Can be set if needed
            'department' => 2,
            'departmentName' => 'Business Economics',
            'email_verified_at' => now(),
            'password' => Hash::make('1234'), // You can set a different password here
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
