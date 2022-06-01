<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
        [
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'created_dt' => date("Y-m-d H:i:s"),
            'updated_dt' => date("Y-m-d H:i:s"),
            'created_by' => 'SYSTEM',
            'updated_by' => 'SYSTEM',
            'role' => 'admin',
        ],
        [
            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('staff'),
            'created_dt' => date("Y-m-d H:i:s"),
            'updated_dt' => date("Y-m-d H:i:s"),
            'created_by' => 'SYSTEM',
            'updated_by' => 'SYSTEM',
            'role' => 'staff',
        ]
        ]);
    }
}
