<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userdata = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'pedagang',
                'email' => 'pedagang@gmail.com',
                'role' => 'pedagang',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'pemebeli',
                'email' => 'pembeli@gmail.com',
                'role' => 'pembeli',
                'password' => bcrypt('password'),
            ],
        ];

        foreach($userdata as $val){
             User::create($val);
        }

    }
}
