<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'           => 'Admin',
                'email'          => 'admin@gmail.com',
                'password'       => bcrypt('12345678'),
                'remember_token' => null,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'status'         => 1,
                'created_by'     => 1,
            ],
            [
                'name'           => 'Neha Staff',
                'email'          => 'staff@gmail.com',
                'password'       => bcrypt('12345678'),
                'remember_token' => null,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'status'         => 1,
                'created_by'     => 1,
            ],
            [
                'name'           => 'Neha Customer',
                'email'          => 'customer@gmail.com',
                'password'       => bcrypt('12345678'),
                'remember_token' => null,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'status'         => 1,
                'created_by'     => 1,
            ],
        ];
        foreach($users as $key=>$user){
            $createdUser =  User::create($user);
        }
    }
}
