<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
                'username'       => 'Admin',
            ],
            [
                'id'             => 2,
                'name'           => 'User',
                'email'          => 'user@user.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
                'username'       => 'User',
            ],
            [
                'id'             => 3,
                'name'           => 'Company',
                'email'          => 'comp@comp.com',
                'password'       => bcrypt('password'),
                'remember_token' => null,
                'approved'       => 1,
                'username'       => 'Company',
            ],
        ];

        User::insert($users);
    }
}
