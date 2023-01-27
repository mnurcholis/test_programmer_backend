<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name'              => 'Admin User',
                'username'          => 'admin',
                'email'             => 'admin@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'type'              => 0,
                'password'          => bcrypt('123'),
            ],
            [
                'name'              => 'Name User',
                'username'          => 'user',
                'email'             => 'user@gmail.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'type'              => 1,
                'password'          => bcrypt('123'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
